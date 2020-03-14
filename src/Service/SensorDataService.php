<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:16
 */

namespace App\Service;

use App\Dto\MapDataDto;
use App\Entity\SensorRecord;
use App\Repository\AqiRepository;
use App\Repository\SensorRecordRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Psr\Log\LoggerInterface;

/**
 * Class SensorDataService
 * @package App\Service
 */
class SensorDataService
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var SensorRecordRepository */
    protected $sensorRecordRepository;

    /** @var MapDataDtoFactory */
    protected $mapDataDtoFactory;

    /** @var AqiRepository */
    protected $aqiRepository;

    /**
     * SensorDataService constructor.
     * @param LoggerInterface $logger
     * @param SensorRecordRepository $sensorRecordRepository
     * @param MapDataDtoFactory $mapDataDtoFactory
     * @param AqiRepository $aqiRepository
     */
    public function __construct(LoggerInterface $logger, SensorRecordRepository $sensorRecordRepository, MapDataDtoFactory $mapDataDtoFactory, AqiRepository $aqiRepository)
    {
        $this->logger = $logger;
        $this->sensorRecordRepository = $sensorRecordRepository;
        $this->mapDataDtoFactory = $mapDataDtoFactory;
        $this->aqiRepository = $aqiRepository;
    }

    /**
     * @param SensorRecord $sensorRecord
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function storeSensorRecord(SensorRecord $sensorRecord): void
    {
        $this->sensorRecordRepository->storeSensorRecord($sensorRecord);
    }

    /**
     * @param \DateTime $from
     * @param string $lat
     * @param string $lng
     * @return MapDataDto
     * @throws \Exception
     */
    public function getDataForMap(\DateTime $from, string $lat = null, string $lng = null): MapDataDto
    {
        $records = $this->aqiRepository->getAqiFrom($from, $lat, $lng);
        $mapDto = $this->mapDataDtoFactory->createDtoFromSensorRecords($records);

        return $mapDto;
    }
}
