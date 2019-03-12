<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SensorValueBreakpointsRepository")
 */
class SensorValueBreakpoints
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SensorValueType", inversedBy="sensorValueBreakpoints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sensorValueType;

    /**
     * @ORM\Column(type="float")
     */
    private $valueMin;

    /**
     * @ORM\Column(type="float")
     */
    private $valueMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $aqiMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $aqiMax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSensorValueType(): ?SensorValueType
    {
        return $this->sensorValueType;
    }

    public function setSensorValueType(?SensorValueType $sensorValueType): self
    {
        $this->sensorValueType = $sensorValueType;

        return $this;
    }

    public function getValueMin(): ?float
    {
        return $this->valueMin;
    }

    public function setValueMin(float $valueMin): self
    {
        $this->valueMin = $valueMin;

        return $this;
    }

    public function getValueMax(): ?float
    {
        return $this->valueMax;
    }

    public function setValueMax(float $valueMax): self
    {
        $this->valueMax = $valueMax;

        return $this;
    }

    public function getAqiMin(): ?int
    {
        return $this->aqiMin;
    }

    public function setAqiMin(int $aqiMin): self
    {
        $this->aqiMin = $aqiMin;

        return $this;
    }

    public function getAqiMax(): ?int
    {
        return $this->aqiMax;
    }

    public function setAqiMax(int $aqiMax): self
    {
        $this->aqiMax = $aqiMax;

        return $this;
    }
}
