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
     * @ORM\OneToMany(targetEntity="App\Entity\SensorValueBreakpoints", mappedBy="sensorValueType")
     */
    private $sensorValueBreakpoints;

    /**
     * @ORM\Column(type="integer")
     */
    private $roundDigits;

    /**
     * @ORM\Column(type="float")
     */
    private $maxPossibleValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInAqi;

    /**
     * Period of average value calculating, in minutes
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $calculatePeriod = 0;

    public function __construct()
    {
        $this->sensorValueBreakpoints = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SensorValueType
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return SensorValueType
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|SensorValueBreakpoints[]
     */
    public function getSensorValueBreakpoints(): Collection
    {
        return $this->sensorValueBreakpoints;
    }

    public function addSensorValueBreakpoint(SensorValueBreakpoints $sensorValueBreakpoint): self
    {
        if (!$this->sensorValueBreakpoints->contains($sensorValueBreakpoint)) {
            $this->sensorValueBreakpoints[] = $sensorValueBreakpoint;
            $sensorValueBreakpoint->setSensorValueType($this);
        }

        return $this;
    }

    public function removeSensorValueBreakpoint(SensorValueBreakpoints $sensorValueBreakpoint): self
    {
        if ($this->sensorValueBreakpoints->contains($sensorValueBreakpoint)) {
            $this->sensorValueBreakpoints->removeElement($sensorValueBreakpoint);
            // set the owning side to null (unless already changed)
            if ($sensorValueBreakpoint->getSensorValueType() === $this) {
                $sensorValueBreakpoint->setSensorValueType(null);
            }
        }

        return $this;
    }

    public function getRoundDigits(): ?int
    {
        return $this->roundDigits;
    }

    public function setRoundDigits(int $roundDigits): self
    {
        $this->roundDigits = $roundDigits;

        return $this;
    }

    public function getMaxPossibleValue(): ?float
    {
        return $this->maxPossibleValue;
    }

    public function setMaxPossibleValue(float $maxPossibleValue): self
    {
        $this->maxPossibleValue = $maxPossibleValue;

        return $this;
    }

    public function getIsInAqi(): ?bool
    {
        return $this->isInAqi;
    }

    public function setIsInAqi(bool $isInAqi): self
    {
        $this->isInAqi = $isInAqi;

        return $this;
    }

    /**
     * @return int
     */
    public function getCalculatePeriod(): int
    {
        return $this->calculatePeriod;
    }

    /**
     * @param int $calculatePeriod
     * @return SensorValueType
     */
    public function setCalculatePeriod(int $calculatePeriod): SensorValueType
    {
        $this->calculatePeriod = $calculatePeriod;
        return $this;
    }
}
