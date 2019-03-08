<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SensorValueRepository")
 */
class SensorValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SensorRecord", inversedBy="sensorValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $record;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SensorValueType", inversedBy="sensorValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $valueType;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecord(): ?SensorRecord
    {
        return $this->record;
    }

    public function setRecord(?SensorRecord $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function getValueType(): ?SensorValueType
    {
        return $this->valueType;
    }

    public function setValueType(?SensorValueType $valueType): self
    {
        $this->valueType = $valueType;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

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
}
