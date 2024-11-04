<?php

namespace App\Module\Vehicle\Entity;

use App\Module\Address\Entity\Address;
use App\Module\CarBrand\Entity\CarBrand;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'vehicle')]
#[ORM\UniqueConstraint(name: 'unique_vin', columns: ['vin'])]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $registrationNumber;

    #[ORM\Column(type: 'string', length: 17, unique: true)]
    private string $vin;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $clientEmail = null;

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

    public function getClientEmail(): ?string
    {
        return $this->clientEmail;
    }

    public function setClientEmail(?string $clientEmail): self
    {
        $this->clientEmail = $clientEmail;
        $this->updateRentalStatus();

        return $this;
    }

    public function isRented(): bool
    {
        return $this->isRented;
    }

    private function updateRentalStatus(): void
    {
        $this->isRented = !empty($this->clientEmail);
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

    protected function updateCurrentLocation(Address $newLocation): void
    {
        $this->currentLocation = $newLocation;
    }
}
