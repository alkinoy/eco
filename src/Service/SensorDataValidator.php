<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:26
 */

namespace App\Service;

/**
 * Class SensorDataValidator
 * @package App\Service
 */
class SensorDataValidator
{

    /**
     * @param array $input
     * @return bool
     */
    public function isSensorInputHasAllMandatoryData(array $input): bool
    {
        $mandatoryFields = [
            SensorInputDataDtoFactory::EXTERNAL_ID_FIELD,
            SensorInputDataDtoFactory::SENSOR_VALUES_FIELD,
            SensorInputDataDtoFactory::SENSOR_LATITUDE_FIELD,
            SensorInputDataDtoFactory::SENSOR_LONGITUDE_FIELD,
        ];

        foreach ($mandatoryFields as $mandatoryField) {
            if (!array_key_exists($mandatoryField, $input)) {
                return false;
            }
        }

        if (!is_array($input[SensorInputDataDtoFactory::SENSOR_VALUES_FIELD])) {
            return false;
        }

        foreach ($input[SensorInputDataDtoFactory::SENSOR_VALUES_FIELD] as $sensorValue) {
            if (!is_array($sensorValue)
                || !array_key_exists(SensorInputDataDtoFactory::SENSOR_VALUE_TYPE_FIELD, $sensorValue)
                || !array_key_exists(SensorInputDataDtoFactory::SENSOR_VALUE_FIELD, $sensorValue)
            ) {
                return false;
            }
        }

        return true;
    }
}
