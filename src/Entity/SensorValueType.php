<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SensorValueTypeRepository")
 */
class SensorValueType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SensorValue", mappedBy="valueType", orphanRemoval=true)
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $sensorValue->setValueType($this);
        }

        return $this;
    }

    public function removeSensorValue(SensorValue $sensorValue): self
    {
        if ($this->sensorValues->contains($sensorValue)) {
            $this->sensorValues->removeElement($sensorValue);
            // set the owning side to null (unless already changed)
            if ($sensorValue->getValueType() === $this) {
                $sensorValue->setValueType(null);
            }
        }

        return $this;
    }
}
