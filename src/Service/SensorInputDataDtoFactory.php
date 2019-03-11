<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 11.03.19
 * Time: 08:27
 */

namespace App\Service;

use App\Dto\SensorInputDataDto;

/**
 * Class SensorInputDataDtoFactory
 * @package App\Service
 */
class SensorInputDataDtoFactory
{
    public const EXTERNAL_ID_FIELD = 'sensorExternalId';
    public const SENSOR_VALUES_FIELD = 'sensorValues';
    public const SENSOR_VALUE_TYPE_FIELD = 'valueType';
    public const SENSOR_VALUE_FIELD = 'value';


    /**
     * @param array $inputData
     * @return SensorInputDataDto
     */
    public function createDtoFromInput(array $inputData): SensorInputDataDto
    {
        $dto = new SensorInputDataDto($inputData[self::EXTERNAL_ID_FIELD]);

        foreach ($inputData[self::SENSOR_VALUES_FIELD] as $sensorPair) {
            $dto->addSensorValue(
                (string)$sensorPair[self::SENSOR_VALUE_TYPE_FIELD],
                (float)$sensorPair[self::SENSOR_VALUE_FIELD]
            );
        }

        return $dto;
    }
}
