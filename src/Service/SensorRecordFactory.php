<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:22
 */

namespace App\Service;

use App\Entity\SensorRecord;

/**
 * Class SensorRecordFactory
 * @package App\Service
 */
class SensorRecordFactory
{

    /**
     * @param array $inputData
     * @return SensorRecord
     */
    public function createSensorRecord(array $inputData): SensorRecord
    {


        return new SensorRecord();
    }
}
