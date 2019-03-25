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

    public const AQI_LEVEL_GOOD = 50;
    public const AQI_LEVEL_MODERATE = 100;
    public const AQI_LEVEL_UNHEALTHY_SENSITIVE = 150;
    public const AQI_LEVEL_UNHEALTHY_ALL = 200;
    public const AQI_LEVEL_VERY_UNHEALTHY = 300;
    public const AQI_LEVEL_HAZARDOUS = 500;

    public const MAP_PRECISION = 0.003;
    public const MAP_ROUND_DIGITS = 6;


    /** @var LoggerInterface */
    protected $logger;

    /** @var SensorValueBreakpointsRepository */
    protected $sensorValueBreakpointRepository;

    /** @var SensorRecordRepository */
    protected $sensorRecordRepository;

    /** @var AqiRepository */
    protected $aqiRepository;

    /**
     * IntegralCalculator constructor.
     * @param LoggerInterface $logger
     * @param SensorValueBreakpointsRepository $sensorValueBreakpointRepository
     * @param SensorRecordRepository $sensorRecordRepository
     * @param AqiRepository $aqiRepository
     */
    public function __construct(LoggerInterface $logger, SensorValueBreakpointsRepository $sensorValueBreakpointRepository, SensorRecordRepository $sensorRecordRepository, AqiRepository $aqiRepository)
    {
        $this->logger = $logger;
        $this->sensorValueBreakpointRepository = $sensorValueBreakpointRepository;
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

        return new CoordinateDto(($startLat + self::MAP_PRECISION/2), ($startLon + self::MAP_PRECISION/2));
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
     * @param int $hoursBack
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function calculateAqiList(int $hoursBack = 24): void
    {
        //TODO refactor it
        $from = (new \DateTime())->sub(new \DateInterval('PT'.(int)$hoursBack.'H'));
        $listOfRecords = $this->sensorRecordRepository->getRecordsFromPeriod($from);

        //create list of squares and sensor records for every of them.
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

        //calculate AQI
        foreach ($squares as $dot) {
            $storeData = true;
            $aqi = (new Aqi())->setLatitude($dot['center']->getLatitude())->setLongitude($dot['center']->getLongitude());

            $sensorValues = [];
            /** @var SensorRecord $record */
            foreach ($dot['records'] as $record) {
                foreach ($record->getSensorValues() as $value){
                    $valueType = $value->getValueType();
                    if (!$valueType->getIsInAqi()) {
                        //this parameter doesn't taken under AQI
                        continue;
                    }

                    $periodToCalculate = $valueType->getCalculatePeriod();
                    $expireDate = (new \DateTime())->sub(new \DateInterval('PT'.(int)$periodToCalculate.'M'));

                    if ($record->getMeasuredAt() < $expireDate) {
                        //Data too old
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

            //calculate AQI
            $integralValue = 0;

            foreach ($sensorValues as $item) {
                /** @var SensorValueType $type */
                $type = $item['type'];
                $sensorValue = round($item['value']/$item['count'], $type->getRoundDigits());
                $sensorValue = min($sensorValue, $type->getMaxPossibleValue());


                $breakpoint = $this->sensorValueBreakpointRepository
                    ->getBreakpoint($type, $sensorValue);

                $a = ($breakpoint->getAqiMax() - $breakpoint->getAqiMin());
                $b = ($sensorValue - $breakpoint->getValueMin());
                $c = ($breakpoint->getValueMax() - $breakpoint->getValueMin());

                $currentIntegrationValue = $a*$b/$c + 101;

                $integralValue = max($integralValue, $currentIntegrationValue);
            }
            $integralValue = min(self::MAX_INDEX_VALUE, $integralValue);
            $integralValue = max(self::MIN_INDEX_VALUE, $integralValue);

            if ($storeData) {
                $aqi->setAqi($integralValue);
                $this->aqiRepository->storeAqi($aqi);
            }
        }
    }
}
