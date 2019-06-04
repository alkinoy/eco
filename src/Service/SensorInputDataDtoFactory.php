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
    public const SENSOR_VALUES_FIELD = 'v';
    public const SENSOR_VALUE_TYPE_FIELD = 'valueType';
    public const SENSOR_VALUE_FIELD = 'value';
    public const SENSOR_LATITUDE_FIELD = 'latitude';
    public const SENSOR_LONGITUDE_FIELD = 'longitude';
    public const SENSOR_MEASURED_AT_FIELD = 'date';
    public const SENSOR_MEASURED_AT_FORMAT = 'YmdHis';


    /**
     * @param array $inputData
     * @return SensorInputDataDto
     */
    public function createDtoFromInput(array $inputData): SensorInputDataDto
    {
        $measureDate = \DateTime::createFromFormat(self::SENSOR_MEASURED_AT_FORMAT, $inputData[self::SENSOR_MEASURED_AT_FIELD]);

        $dto = new SensorInputDataDto($inputData[self::EXTERNAL_ID_FIELD]);
        $dto->setLatitude($inputData[self::SENSOR_LATITUDE_FIELD])
            ->setLongitude($inputData[self::SENSOR_LONGITUDE_FIELD])
            ->setMeasuredAt($measureDate)
        ;

        foreach ($inputData[self::SENSOR_VALUES_FIELD] as $sensorPair) {
            $dto->addSensorValue(
                (string)$sensorPair[self::SENSOR_VALUE_TYPE_FIELD],
                (float)$sensorPair[self::SENSOR_VALUE_FIELD]
            );
        }

        return $dto;
    }
}
