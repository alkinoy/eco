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
     * @param SensorRecord $sensorRecord
     * @param SensorValueType $valueType
     * @param float $value
     * @throws \Exception
     */
    public function __construct(SensorRecord $sensorRecord, SensorValueType $valueType, float $value)
    {
        $this->createdAt = new \DateTime();
        $this->record = $sensorRecord;
        $this->valueType = $valueType;
        $this->value = $value;
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
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
