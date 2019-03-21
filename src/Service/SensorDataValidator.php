<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:26
 */

namespace App\Service;

use App\Exception\SensorInputDataValidationException;
use Psr\Log\LoggerInterface;

/**
 * Class SensorDataValidator
 * @package App\Service
 */
class SensorDataValidator
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * SensorDataValidator constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array $input
     * @return bool
     * @throws SensorInputDataValidationException
     */
    public function validateInputData(array $input): bool
    {
        $mandatoryFields = [
            SensorInputDataDtoFactory::EXTERNAL_ID_FIELD,
            SensorInputDataDtoFactory::SENSOR_VALUES_FIELD,
            SensorInputDataDtoFactory::SENSOR_LATITUDE_FIELD,
            SensorInputDataDtoFactory::SENSOR_LONGITUDE_FIELD,
            SensorInputDataDtoFactory::SENSOR_MEASURED_AT_FIELD,
        ];

        $errorId = uniqid('', false);

        foreach ($mandatoryFields as $mandatoryField) {
            if (!array_key_exists($mandatoryField, $input)) {
                $message = 'Input Data validation failed. Mandatory field '.$mandatoryField.' is absent. Error id: '.$errorId;
                $this->logger->warning($message, ['inputData' => $input, 'errorId' => $errorId]);

                throw new SensorInputDataValidationException($message);
            }
        }

        $measureDate = \DateTime::createFromFormat(
            SensorInputDataDtoFactory::SENSOR_MEASURED_AT_FORMAT,
            $input[SensorInputDataDtoFactory::SENSOR_MEASURED_AT_FIELD]
        );

        if (false === $measureDate) {
            $message = 'Input Data validation failed. Sensor measure date has wrong format. Error id: '.$errorId;
            $this->logger->warning($message, ['inputData' => $input, 'errorId' => $errorId]);

            throw new SensorInputDataValidationException($message);
        }

        if (!is_array($input[SensorInputDataDtoFactory::SENSOR_VALUES_FIELD])) {
            $message = 'Input Data validation failed. Sensor data field is not an array. Error id: '.$errorId;
            $this->logger->warning($message, ['inputData' => $input, 'errorId' => $errorId]);

            throw new SensorInputDataValidationException($message);
        }

        foreach ($input[SensorInputDataDtoFactory::SENSOR_VALUES_FIELD] as $sensorValue) {
            if (!is_array($sensorValue)
                || !array_key_exists(SensorInputDataDtoFactory::SENSOR_VALUE_TYPE_FIELD, $sensorValue)
                || !array_key_exists(SensorInputDataDtoFactory::SENSOR_VALUE_FIELD, $sensorValue)
            ) {
                $message = 'Input Data validation failed. One of the sensor value pairs is wrong. Error id: '.$errorId;
                $this->logger->warning($message, ['inputData' => $input, 'errorId' => $errorId]);

                throw new SensorInputDataValidationException($message);
            }
        }

        return true;
    }
}
