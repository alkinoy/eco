<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SensorRepository")
 */
class Sensor
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
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $externalId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SensorRecord", mappedBy="sensor", orphanRemoval=true)
     */
    private $sensorRecords;

    /**
     * Sensor constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->sensorRecords = new ArrayCollection();
        $this->externalId = uniqid('', false);
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
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
     * @return Sensor
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Sensor
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Sensor
     */
    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Sensor
     */
    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    /**
     * @return Collection|SensorRecord[]
     */
    public function getSensorRecords(): Collection
    {
        return $this->sensorRecords;
    }

    /**
     * @param SensorRecord $sensorRecord
     * @return Sensor
     */
    public function addSensorRecord(SensorRecord $sensorRecord): self
    {
        if (!$this->sensorRecords->contains($sensorRecord)) {
            $this->sensorRecords[] = $sensorRecord;
            $sensorRecord->setSensor($this);
        }

        return $this;
    }

    /**
     * @param SensorRecord $sensorRecord
     * @return Sensor
     */
    public function removeSensorRecord(SensorRecord $sensorRecord): self
    {
        if ($this->sensorRecords->contains($sensorRecord)) {
            $this->sensorRecords->removeElement($sensorRecord);
            // set the owning side to null (unless already changed)
            if ($sensorRecord->getSensor() === $this) {
                $sensorRecord->setSensor(null);
            }
        }

        return $this;
    }
}
