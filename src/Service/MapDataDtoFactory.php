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
use App\Entity\Aqi;
use App\Entity\SensorRecord;

/**
 * Class MapDataDtoFactory
 * @package App\Service
 */
class MapDataDtoFactory
{

    /**
     * @param array|Aqi[] $aqiRecords
     * @return MapDataDto
     * @throws \Exception
     */
    public function createDtoFromSensorRecords(array $aqiRecords): MapDataDto
    {
        $mapDataDto = new MapDataDto();
        /** @var SensorRecord $sensorRecord */
        foreach ($aqiRecords as $record) {
            $dto = (new MapSensorDataDto())
                ->setAqi($record->getAqi())
                ->setLatitude($record->getLatitude())
                ->setLongitude($record->getLongitude())
                ->setCreatedAt($record->getCreatedAt())
            ;

            $mapDataDto->addSensorDataList($dto);
        }

        return $mapDataDto;
    }
}
