<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 08.03.19
 * Time: 14:52
 */

namespace App\Dto;

/**
 * Class SensorInputDataDto
 * @package App\Dto
 */
class SensorInputDataDto
{
    /** @var string */
    protected $externalSensorId;

    /** @var float  */
    protected $latitude = 0.0;

    /** @var float  */
    protected $longitude = 0.0;

    /** @var array */
    protected $sensorValues = [];

    /** @var \DateTime */
    protected $measuredAt;

    /**
     * SensorInputDataDto constructor.
     * @param string $externalSensorId
     */
    public function __construct(string $externalSensorId)
    {
        $this->externalSensorId = $externalSensorId;
    }

    /**
     * @return string
     */
    public function getExternalSensorId(): string
    {
        return $this->externalSensorId;
    }

    /**
     * @param string $type
     * @param float $value
     * @return SensorInputDataDto
     */
    public function addSensorValue(string $type, float $value): self
    {
        $this->sensorValues[$type] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getSensorValues(): array
    {
        return $this->sensorValues;
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
     * @return SensorInputDataDto
     */
    public function setLatitude(float $latitude): SensorInputDataDto
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
     * @return SensorInputDataDto
     */
    public function setLongitude(float $longitude): SensorInputDataDto
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getMeasuredAt(): ?\DateTime
    {
        return $this->measuredAt;
    }

    /**
     * @param \DateTime $measuredAt
     * @return SensorInputDataDto
     */
    public function setMeasuredAt(\DateTime $measuredAt): SensorInputDataDto
    {
        $this->measuredAt = $measuredAt;
        return $this;
    }
}
