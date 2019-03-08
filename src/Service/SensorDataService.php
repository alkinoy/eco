<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:16
 */

namespace App\Service;

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

    /**
     * SensorDataService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger, SensorRecordRepository $repository)
    {
        $this->logger = $logger;
        $this->sensorRecordRepository = $repository;
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
}
