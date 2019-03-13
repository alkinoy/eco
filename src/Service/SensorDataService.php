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
use App\Repository\SensorRecordRepository;
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

    /**
     * SensorDataService constructor.
     * @param LoggerInterface $logger
     * @param SensorRecordRepository $sensorRecordRepository
     * @param MapDataDtoFactory $mapDataDtoFactory
     */
    public function __construct(LoggerInterface $logger, SensorRecordRepository $sensorRecordRepository, MapDataDtoFactory $mapDataDtoFactory)
    {
        $this->logger = $logger;
        $this->sensorRecordRepository = $sensorRecordRepository;
        $this->mapDataDtoFactory = $mapDataDtoFactory;
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
     * @return MapDataDto
     */
    public function getDataForMap(): MapDataDto
    {
        $records = $this->sensorRecordRepository->findAll();
        $mapDto = $this->mapDataDtoFactory->createDtoFromSensorRecords($records);

        return $mapDto;

    }
}
