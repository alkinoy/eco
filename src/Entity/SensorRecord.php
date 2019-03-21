<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SensorRecordRepository")
 */
class SensorRecord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sensor", inversedBy="sensorRecords")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sensor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SensorValue", mappedBy="record", orphanRemoval=true, cascade={"all"})
     */
    private $sensorValues;

    /**
     * @ORM\Column(type="float")
     */
    private $integralValue = 0;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $latitude = 0.0;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $longitude = 0.0;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $measuredAt;

    /**
     * SensorRecord constructor.
     * @param Sensor $sensor
     * @throws \Exception
     */
    public function __construct(Sensor $sensor)
    {
        $this->sensorValues = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->sensor = $sensor;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Sensor|null
     */
    public function getSensor(): ?Sensor
    {
        return $this->sensor;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return Collection|SensorValue[]
     */
    public function getSensorValues(): Collection
    {
        return $this->sensorValues;
    }

    /**
     * @param SensorValue $sensorValue
     * @return SensorRecord
     */
    public function addSensorValue(SensorValue $sensorValue): self
    {
        if (!$this->sensorValues->contains($sensorValue)) {
            $this->sensorValues[] = $sensorValue;
            $sensorValue->setRecord($this);
        }

        return $this;
    }

    /**
     * @param SensorValue $sensorValue
     * @return SensorRecord
     */
    public function removeSensorValue(SensorValue $sensorValue): self
    {
        if ($this->sensorValues->contains($sensorValue)) {
            $this->sensorValues->removeElement($sensorValue);
            // set the owning side to null (unless already changed)
            if ($sensorValue->getRecord() === $this) {
                $sensorValue->setRecord(null);
            }
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getIntegralValue(): float
    {
        return $this->integralValue;
    }

    /**
     * @param float $integralValue
     * @return SensorRecord
     */
    public function setIntegralValue(float $integralValue): SensorRecord
    {
        $this->integralValue = $integralValue;
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
     * @return SensorRecord
     */
    public function setLatitude(float $latitude): SensorRecord
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
     * @return SensorRecord
     */
    public function setLongitude(float $longitude): SensorRecord
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getMeasuredAt(): ?\DateTime
    {
        return $this->measuredAt;
    }

    /**
     * @param \DateTime $measuredAt
     * @return SensorRecord
     */
    public function setMeasuredAt(\DateTime $measuredAt): SensorRecord
    {
        $this->measuredAt = $measuredAt;
        return $this;
    }
}
