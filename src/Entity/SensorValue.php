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

    /**
     * SensorValue constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return SensorRecord|null
     */
    public function getRecord(): ?SensorRecord
    {
        return $this->record;
    }

    /**
     * @param SensorRecord|null $record
     * @return SensorValue
     */
    public function setRecord(?SensorRecord $record): self
    {
        $this->record = $record;

        return $this;
    }

    /**
     * @return SensorValueType|null
     */
    public function getValueType(): ?SensorValueType
    {
        return $this->valueType;
    }

    /**
     * @param SensorValueType|null $valueType
     * @return SensorValue
     */
    public function setValueType(?SensorValueType $valueType): self
    {
        $this->valueType = $valueType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return SensorValue
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
