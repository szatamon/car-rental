<?php

namespace App\Module\Vehicle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Module\Address\Entity\Address;
use App\Module\CarBrand\Entity\CarBrand;

#[ORM\Entity()]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $registrationNumber;

    #[ORM\Column(type: 'string', length: 17)]
    private string $vin;

    #[ORM\Column(type: 'string', length: 100)]
    private string $clientEmail;

    #[ORM\Column(type: 'boolean')]
    private bool $isRented = false;

    #[ORM\ManyToOne(targetEntity: CarBrand::class)]
    #[ORM\JoinColumn(nullable: false)]
    private CarBrand $brand;

    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Address $clientAddress = null;

    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Address $currentLocation = null;

    // Gettery i settery dla każdego pola

    public function getId(): int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): self
    {
        $this->vin = $vin;
        return $this;
    }

    public function getClientEmail(): string
    {
        return $this->clientEmail;
    }

    public function setClientEmail(string $clientEmail): self
    {
        $this->clientEmail = $clientEmail;
        return $this;
    }

    public function isRented(): bool
    {
        return $this->isRented;
    }

    public function setIsRented(bool $isRented): self
    {
        $this->isRented = $isRented;
        return $this;
    }

    public function getBrand(): CarBrand
    {
        return $this->brand;
    }

    public function setBrand(CarBrand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getClientAddress(): ?Address
    {
        return $this->clientAddress;
    }

    public function setClientAddress(?Address $clientAddress): self
    {
        $this->clientAddress = $clientAddress;
        return $this;
    }

    public function getCurrentLocation(): ?Address
    {
        return $this->currentLocation;
    }

    public function setCurrentLocation(?Address $currentLocation): self
    {
        $this->currentLocation = $currentLocation;
        return $this;
    }
}