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
     * @ORM\OneToMany(targetEntity="App\Entity\SensorValue", mappedBy="record", orphanRemoval=true)
     */
    private $sensorValues;

    public function __construct()
    {
        $this->sensorValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSensor(): ?Sensor
    {
        return $this->sensor;
    }

    public function setSensor(?Sensor $sensor): self
    {
        $this->sensor = $sensor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|SensorValue[]
     */
    public function getSensorValues(): Collection
    {
        return $this->sensorValues;
    }

    public function addSensorValue(SensorValue $sensorValue): self
    {
        if (!$this->sensorValues->contains($sensorValue)) {
            $this->sensorValues[] = $sensorValue;
            $sensorValue->setRecord($this);
        }

        return $this;
    }

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
