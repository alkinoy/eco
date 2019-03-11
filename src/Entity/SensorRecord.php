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
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
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
}
