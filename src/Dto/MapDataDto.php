<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 13.03.19
 * Time: 15:27
 */

namespace App\Dto;

/**
 * Class MapDataDto
 * @package App\Dto
 */
class MapDataDto
{
    /** @var MapSensorDataDto[]|array */
    protected $sensorDataList = [];

    /**
     * @return MapSensorDataDto[]|array
     */
    public function getSensorDataList()
    {
        return $this->sensorDataList;
    }

    /**
     * @param MapSensorDataDto $dto
     * @return MapDataDto
     */
    public function addSensorDataList(MapSensorDataDto $dto): MapDataDto
    {
        $this->sensorDataList[] = $dto;

        return $this;
    }
}
