<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 13.03.19
 * Time: 15:23
 */

namespace App\Dto;

/**
 * Class MapSensorDataDto
 * @package App\Dto
 */
class MapSensorDataDto
{
    /** @var integer */
    protected $sensorInternalId = 0;

    /** @var float */
    protected $latitude = 0.0;

    /** @var float */
    protected $longitude = 0.0;

    /** @var integer */
    protected $aqi = 0;

    /** @var \DateTime */
    protected $createdAt;

    /**
     * @return int
     */
    public function getSensorInternalId(): int
    {
        return $this->sensorInternalId;
    }

    /**
     * @param int $sensorInternalId
     * @return MapSensorDataDto
     */
    public function setSensorInternalId(int $sensorInternalId): MapSensorDataDto
    {
        $this->sensorInternalId = $sensorInternalId;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return MapSensorDataDto
     */
    public function setLatitude(float $latitude): MapSensorDataDto
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return MapSensorDataDto
     */
    public function setLongitude(float $longitude): MapSensorDataDto
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return int
     */
    public function getAqi(): int
    {
        return $this->aqi;
    }

    /**
     * @param int $aqi
     * @return MapSensorDataDto
     */
    public function setAqi(int $aqi): MapSensorDataDto
    {
        $this->aqi = $aqi;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return MapSensorDataDto
     */
    public function setCreatedAt(\DateTime $createdAt): MapSensorDataDto
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
