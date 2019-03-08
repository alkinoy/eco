<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:22
 */

namespace App\Service;

use App\Entity\SensorRecord;
use App\Repository\SensorRepository;
use App\Repository\SensorValueTypeRepository;

/**
 * Class SensorRecordFactory
 * @package App\Service
 */
class SensorRecordFactory
{
    /** @var SensorRepository */
    protected $sensorRepository;

    /** @var SensorValueTypeRepository */
    protected $sensorValueTypeRepository;

    /**
     * SensorRecordFactory constructor.
     * @param SensorRepository $sensorRepository
     * @param SensorValueTypeRepository $sensorValueTypeRepository
     */
    public function __construct(SensorRepository $sensorRepository, SensorValueTypeRepository $sensorValueTypeRepository)
    {
        $this->sensorRepository = $sensorRepository;
        $this->sensorValueTypeRepository = $sensorValueTypeRepository;
    }


    /**
     * @param array $inputData
     * @return SensorRecord
     */
    public function createSensorRecord(array $inputData): SensorRecord
    {
        $sensor = $this->sensorRepository->findOneBy(['externalId' => $inputData['externalId']]);

        return new SensorRecord();
    }
}
