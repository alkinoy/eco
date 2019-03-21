<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 13.03.19
 * Time: 16:02
 */

namespace App\Service;

use App\Dto\MapDataDto;

/**
 * Class MapDtoSerializer
 * @package App\Service
 */
class MapDtoSerializer
{
    public const LATITUDE_NAME = 'lat';
    public const LONGITUDE_NAME = 'lng';
    public const AQI_NAME = 'aqi';
    public const DATE_NAME = 'date';

    /**
     * с бека данные приходят в таком виде
    points = [
    {lat:50.50, lng:30.78, color: '#FF0000'},
    ...
    ];

     */

    /**
     * @param MapDataDto $dto
     * @return array
     * @throws \Exception
     */
    public function serialize(MapDataDto $dto): array
    {
        $result = [];
        foreach ($dto->getSensorDataList() as $item) {
            $tmp = [];
            $tmp[self::LATITUDE_NAME] = $item->getLatitude();
            $tmp[self::LONGITUDE_NAME] = $item->getLongitude();
            $tmp[self::AQI_NAME] = $item->getAqi();
            $tmp[self::DATE_NAME] = $item->getMeasuredAt()->format('Y.m.d H:i:s');

            $result[] = $tmp;
        }

        return $result;
    }
}
