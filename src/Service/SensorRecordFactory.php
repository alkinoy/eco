<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:22
 */

namespace App\Service;

use App\Dto\SensorInputDataDto;
use App\Entity\SensorRecord;
use App\Entity\SensorValue;
use App\Exception\SensorNotFoundException;
use App\Repository\SensorRepository;
use App\Repository\SensorValueTypeRepository;
use Psr\Log\LoggerInterface;

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

    /** @var LoggerInterface */
    protected $logger;

    /**
     * SensorRecordFactory constructor.
     * @param SensorRepository $sensorRepository
     * @param SensorValueTypeRepository $sensorValueTypeRepository
     * @param LoggerInterface $logger
     */
    public function __construct(SensorRepository $sensorRepository, SensorValueTypeRepository $sensorValueTypeRepository, LoggerInterface $logger)
    {
        $this->sensorRepository = $sensorRepository;
        $this->sensorValueTypeRepository = $sensorValueTypeRepository;
        $this->logger = $logger;
    }

    /**
     * @param SensorInputDataDto $inputData
     * @return SensorRecord
     * @throws SensorNotFoundException
     * @throws \Exception
     */
    public function createSensorRecord(SensorInputDataDto $inputData): SensorRecord
    {
        $sensor = $this->sensorRepository->findOneBy(['externalId' => $inputData->getExternalSensorId()]);

        if (null === $sensor) {
            throw new SensorNotFoundException('Sensor with external id '.$inputData->getExternalSensorId().' not found');
        }

        $sensorRecord = new SensorRecord($sensor);

        foreach ($inputData->getSensorValues() as $valueType => $value) {
            $valueTypeEntity = $this->sensorValueTypeRepository->findOneBy(['name' => $valueType]);

            if (null === $valueTypeEntity) {
                $this->logger->error(
                    'ValueType not found. Value omitted.',
                    [
                        'sensorId' => $sensor->getId(),
                        'valueTypeName' => $valueType,
                    ]
                );

                continue;
            }

            $sensorValue = new SensorValue($sensorRecord, $valueTypeEntity, $value);
            $sensorRecord->addSensorValue($sensorValue);
        }

        return $sensorRecord;
    }
}
