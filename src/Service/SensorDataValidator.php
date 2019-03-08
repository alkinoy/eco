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
        $mandatoryFields = ['sensorExternalId', 'sensorValues'];

        foreach ($mandatoryFields as $mandatoryField) {
            if (!array_key_exists($mandatoryField, $input)) {
                return false;
            }
        }

        if (!is_array($input['sensorValues'])) {
            return false;
        }

        foreach ($input['sensorValues'] as $sensorValue) {
            if (!is_array($sensorValue)
                || !array_key_exists('valueType', $sensorValue)
                || !array_key_exists('value', $sensorValue)
            ) {
                return false;
            }
        }

        return true;
    }
}
