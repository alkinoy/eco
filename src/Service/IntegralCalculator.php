<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 12.03.19
 * Time: 08:36
 */

namespace App\Service;

use App\Dto\CoordinateDto;
use App\Entity\Aqi;
use App\Entity\SensorRecord;
use App\Entity\SensorValueType;
use App\Repository\AqiRepository;
use App\Repository\SensorValueTypeRepository;
use App\Repository\SensorRecordRepository;
use App\Repository\SensorValueBreakpointsRepository;
use Psr\Log\LoggerInterface;

/**
 * Class IntegralCalculator
 * @package App\Service
 */
class IntegralCalculator
{
    public const MIN_INDEX_VALUE = 0;
    public const MAX_INDEX_VALUE = 500;

    public const MAP_PRECISION = 0.004;
    public const MAP_ROUND_DIGITS = 6;


    /** @var LoggerInterface */
    protected $logger;

    /** @var SensorValueBreakpointsRepository */
    protected $sensorValueBreakpointRepository;

    /** @var SensorValueTypeRepository */
    protected $sensorValueTypeRepository;

    /** @var SensorRecordRepository */
    protected $sensorRecordRepository;

    /** @var AqiRepository */
    protected $aqiRepository;

    /**
     * IntegralCalculator constructor.
     * @param LoggerInterface $logger
     * @param SensorValueBreakpointsRepository $sensorValueBreakpointRepository
     * @param SensorValueTypeRepository $sensorValueTypeRepository
     * @param SensorRecordRepository $sensorRecordRepository
     * @param AqiRepository $aqiRepository
     */
    public function __construct(
        LoggerInterface $logger,
        SensorValueBreakpointsRepository $sensorValueBreakpointRepository,
        SensorValueTypeRepository $sensorValueTypeRepository,
        SensorRecordRepository $sensorRecordRepository,
        AqiRepository $aqiRepository
    )
    {
        $this->logger = $logger;
        $this->sensorValueBreakpointRepository = $sensorValueBreakpointRepository;
        $this->sensorValueTypeRepository = $sensorValueTypeRepository;
        $this->sensorRecordRepository = $sensorRecordRepository;
        $this->aqiRepository = $aqiRepository;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return CoordinateDto
     */
    public function getDotCenterForLatLon(float $latitude, float $longitude): CoordinateDto
    {
        $startLat = self::MAP_PRECISION * floor($latitude / self::MAP_PRECISION);
        $startLon = self::MAP_PRECISION * floor($longitude / self::MAP_PRECISION);

        return new CoordinateDto(($startLat + self::MAP_PRECISION / 2), ($startLon + self::MAP_PRECISION / 2));
    }

    /**
     * @param CoordinateDto $dto
     * @return string
     */
    protected function getCenterLiteral(CoordinateDto $dto): string
    {
        return (string)$dto->getLatitude().'-'.(string)$dto->getLongitude();
    }

    /**
     * @param \DateTime $inputDate
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function calculateAqiList(\DateTime $inputDate): void
    {
        if ($this->aqiRepository->isExist($inputDate)) {
            $this->logger->info('AQI already counted', ['inputDate' => $inputDate]);
            return;
        }
        $period = $this->sensorValueTypeRepository->getMaxPeriod();
        $listOfRecords = $this->sensorRecordRepository->getRecordsFromPeriod(
            (clone $inputDate)->sub(new \DateInterval('PT'.(int)$period.'M')),
            $inputDate
        );

        // $this->logger->info(count($listOfRecords).' records found for AQI calculation.');

        // create list of squares and sensor records for every of them.
        $squares = [];
        foreach ($listOfRecords as $sensorRecord) {
            $centerOfSquare = $this->getDotCenterForLatLon($sensorRecord->getLatitude(), $sensorRecord->getLongitude());
            $centerIndex = $this->getCenterLiteral($centerOfSquare);
            if (!isset($squares[$centerIndex])) {
                $squares[$centerIndex]['records'] = [];
                $squares[$centerIndex]['center'] = $centerOfSquare;
            }

            $squares[$centerIndex]['records'][] = $sensorRecord;
        }

        // prepare data set
        foreach ($squares as $dot) {
            $storeData = false;
            $aqi = (new Aqi())
                ->setLatitude($dot['center']->getLatitude())
                ->setLongitude($dot['center']->getLongitude())
                ->setCreatedAt($inputDate);

            $sensorValues = [];
            /** @var SensorRecord $record */
            foreach ($dot['records'] as $record) {
                foreach ($record->getSensorValues() as $value) {
                    $valueType = $value->getValueType();
                    if (!$valueType->getIsInAqi()) {
                        // this parameter doesn't taken under AQI
                        // $this->logger->info('Sensor data doesn\'t used for AQI calculation', ['valueType' => $valueType->getName(),]);
                        continue;
                    }

                    $periodToCalculate = $valueType->getCalculatePeriod();
                    $expireDate = (clone $inputDate)->sub(new \DateInterval('PT'.(int)$periodToCalculate.'M'));

                    if ($record->getMeasuredAt() < $expireDate) {
                        // Data too old
                        // $this->logger->info(
                        //     'Sensor record omitted due to expired date',
                        //     [
                        //         'valueType' => $valueType->getName(),
                        //         'dataMeasuredAt' => $record->getMeasuredAt(),
                        //     ]
                        // );
                        continue;
                    }

                    $storeData = true;

                    if (!isset($sensorValues[$valueType->getType()])) {
                        $sensorValues[$valueType->getType()] = [
                            'type' => $valueType,
                            'value' => 0,
                            'count' => 0,
                        ];
                    }
                    $sensorValues[$valueType->getType()]['count']++;
                    $sensorValues[$valueType->getType()]['value'] += $value->getValue();
                    $record->addAqi($aqi);
                    $aqi->addSensorRecord($record);
                }
            }

            // calculate AQI
            $integralValue = 0;

            foreach ($sensorValues as $item) {
                /** @var SensorValueType $type */
                $type = $item['type'];
                $sensorValue = round($item['value']/$item['count'], $type->getRoundDigits());
                $sensorValue = min($sensorValue, $type->getMaxPossibleValue());

                $breakpoint = $this->sensorValueBreakpointRepository
                    ->getBreakpoint($type, $sensorValue);

                if (!$breakpoint) {
                    continue;
                }

                $a = ($breakpoint->getAqiMax() - $breakpoint->getAqiMin());
                $b = ($sensorValue - $breakpoint->getValueMin());
                $c = ($breakpoint->getValueMax() - $breakpoint->getValueMin());

                $currentIntegrationValue = $a*$b/$c + $breakpoint->getValueMin();

                $integralValue = max($integralValue, $currentIntegrationValue);
            }

            $integralValue = min(self::MAX_INDEX_VALUE, $integralValue);
            $integralValue = max(self::MIN_INDEX_VALUE, $integralValue);

            if ($storeData) {
                $aqi->setAqi($integralValue);
                $this->aqiRepository->storeAqi($aqi);
                $this->logger->info('AQI record created');
            }
        }
    }
}
