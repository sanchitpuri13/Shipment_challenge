<?php

namespace App\Entity;

use App\Dto\ShipmentOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShipmentRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ShipmentRepository::class)
 * 
 * @ApiResource(
 *      collectionOperations={"get"={"method"="GET", "output"=ShipmentOutput::class}},
 *      itemOperations={}
 *      )
 * @ApiFilter(SearchFilter::class, properties={"company.name": "exact", "carrier.name": "exact", "origin_stop_id": "exact", "destination_stop_id": "exact"})
 */
class Shipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="shipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Carrier::class, inversedBy="shipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carrier;

    /**
     * @ORM\Column(type="integer")
     */
    private $shipmentId;

    /**
     * @ORM\Column(type="integer")
     */
    private $distanceInMeters;

    /**
     * @ORM\Column(type="float")
     */
    private $distanceInKm;

    /**
     * @ORM\Column(type="float")
     */
    private $shipmentTime;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     */
    private $originStopId;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $originPostcode;

    /**
     * @ORM\Column(type="string", length=90)
     */
    private $originCity;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $originCountry;

    /**
     * @ORM\Column(type="integer")
     */
    private $destinationStopId;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $destinationPostcode;

    /**
     * @ORM\Column(type="string", length=90)
     */
    private $destinationCity;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $destinationCountry;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): self
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getShipmentId(): ?int
    {
        return $this->shipmentId;
    }

    public function setShipmentId(int $shipmentId): self
    {
        $this->shipmentId = $shipmentId;

        return $this;
    }

    public function getDistanceInMeters(): ?int
    {
        return $this->distanceInMeters;
    }

    public function setDistanceInMeters(int $distanceInMeters): self
    {
        $this->distanceInMeters = $distanceInMeters;

        return $this;
    }

    public function getDistanceInKm(): ?float
    {
        return $this->distanceInKm;
    }

    public function setDistanceInKm(float $distanceInKm): self
    {
        $this->distanceInKm = $distanceInKm;

        return $this;
    }

    public function getShipmentTime(): ?float
    {
        return $this->shipmentTime;
    }

    public function setShipmentTime(int $shipmentTime): self
    {
        $this->shipmentTime = $shipmentTime;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getOriginStopId(): ?int
    {
        return $this->originStopId;
    }

    public function setOriginStopId(int $originStopId): self
    {
        $this->originStopId = $originStopId;

        return $this;
    }

    public function getOriginPostcode(): ?string
    {
        return $this->originPostcode;
    }

    public function setOriginPostcode(string $originPostcode): self
    {
        $this->originPostcode = $originPostcode;

        return $this;
    }

    public function getOriginCity(): ?string
    {
        return $this->originCity;
    }

    public function setOriginCity(string $originCity): self
    {
        $this->originCity = $originCity;

        return $this;
    }

    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    public function setOriginCountry(string $originCountry): self
    {
        $this->originCountry = $originCountry;

        return $this;
    }

    public function getDestinationStopId(): ?int
    {
        return $this->destinationStopId;
    }

    public function setDestinationStopId(int $destinationStopId): self
    {
        $this->destinationStopId = $destinationStopId;

        return $this;
    }

    public function getDestinationPostcode(): ?string
    {
        return $this->destinationPostcode;
    }

    public function setDestinationPostcode(string $destinationPostcode): self
    {
        $this->destinationPostcode = $destinationPostcode;

        return $this;
    }

    public function getDestinationCity(): ?string
    {
        return $this->destinationCity;
    }

    public function setDestinationCity(string $destinationCity): self
    {
        $this->destinationCity = $destinationCity;

        return $this;
    }

    public function getDestinationCountry(): ?string
    {
        return $this->destinationCountry;
    }

    public function setDestinationCountry(string $destinationCountry): self
    {
        $this->destinationCountry = $destinationCountry;

        return $this;
    }
}
