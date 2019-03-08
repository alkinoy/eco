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

    /** @var array */
    protected $sensorValues = [];

    /**
     * SensorInputDataDto constructor.
     * @param string $externalSensorId
     */
    public function __construct(string $externalSensorId)
    {
        $this->externalSensorId = $externalSensorId;
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
}
