<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 13.03.19
 * Time: 15:56
 */

namespace App\Service;

use App\Dto\MapDataDto;
use App\Dto\MapSensorDataDto;
use App\Entity\SensorRecord;

/**
 * Class MapDataDtoFactory
 * @package App\Service
 */
class MapDataDtoFactory
{

    /**
     * @param array $sensorRecords
     * @return MapDataDto
     */
    public function createDtoFromSensorRecords(array $sensorRecords): MapDataDto
    {
        $mapDataDto = new MapDataDto();
        /** @var SensorRecord $sensorRecord */
        foreach ($sensorRecords as $sensorRecord) {
            $dto = (new MapSensorDataDto())
                ->setAqi($sensorRecord->getIntegralValue())
                ->setLatitude($sensorRecord->getLatitude())
                ->setLongitude($sensorRecord->getLongitude())
                ->setSensorInternalId($sensorRecord->getSensor()->getId())
                ->setCreatedAt($sensorRecord->getCreatedAt())
            ;

            $mapDataDto->addSensorDataList($dto);
        }

        return $mapDataDto;
    }
}
