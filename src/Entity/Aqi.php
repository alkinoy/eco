<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AqiRepository")
 */
class Aqi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $aqi;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SensorRecord", inversedBy="aqis")
     */
    private $sensorRecords;

    public function __construct()
    {
        $this->sensorRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAqi(): ?int
    {
        return $this->aqi;
    }

    public function setAqi(int $aqi): self
    {
        $this->aqi = $aqi;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|SensorRecord[]
     */
    public function getSensorRecords(): Collection
    {
        return $this->sensorRecords;
    }

    public function addSensorRecord(SensorRecord $sensorRecord): self
    {
        if (!$this->sensorRecords->contains($sensorRecord)) {
            $this->sensorRecords[] = $sensorRecord;
        }

        return $this;
    }

    public function removeSensorRecord(SensorRecord $sensorRecord): self
    {
        if ($this->sensorRecords->contains($sensorRecord)) {
            $this->sensorRecords->removeElement($sensorRecord);
        }

        return $this;
    }
}
