<?php

namespace Tests\Module\Vehicle\Entity;

use App\Module\Address\Entity\Address;
use App\Module\CarBrand\Entity\CarBrand;
use App\Module\Vehicle\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    private Vehicle $vehicle;

    protected function setUp(): void
    {
        // Inicjalizacja nowego obiektu Vehicle przed każdym testem
        $this->vehicle = new Vehicle();
    }

    public function testGetId()
    {
        // Testujemy, czy id jest prawidłowo ustawiane
        $reflection = new \ReflectionClass($this->vehicle);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($this->vehicle, 1);

        $this->assertEquals(1, $this->vehicle->getId());
    }

    public function testSetAndGetRegistrationNumber()
    {
        $this->vehicle->setRegistrationNumber('ABC123');
        $this->assertEquals('ABC123', $this->vehicle->getRegistrationNumber());
    }

    public function testSetAndGetVin()
    {
        $this->vehicle->setVin('1HGCM82633A123456');
        $this->assertEquals('1HGCM82633A123456', $this->vehicle->getVin());
    }

    public function testSetAndGetClientEmail()
    {
        $this->vehicle->setClientEmail('client@example.com');
        $this->assertEquals('client@example.com', $this->vehicle->getClientEmail());
    }

    public function testIsRentedReturnsFalseByDefault()
    {
        $this->assertFalse($this->vehicle->isRented());
    }

    public function testIsRentedReturnsTrueWhenClientEmailIsSet()
    {
        $this->vehicle->setClientEmail('client@example.com');
        $this->assertTrue($this->vehicle->isRented());
    }

    public function testSetClientEmailUpdatesRentalStatus()
    {
        // Sprawdzenie, że ustawienie emaila aktualizuje status wynajmu
        $this->vehicle->setClientEmail('client@example.com');
        $this->assertTrue($this->vehicle->isRented());

        // Ustawienie emaila na null powinno ustawić status wynajmu na false
        $this->vehicle->setClientEmail(null);
        $this->assertFalse($this->vehicle->isRented());
    }

    public function testSetAndGetBrand()
    {
        $carBrand = new CarBrand();
        $carBrand->setName('Test Brand'); // Ustalamy nazwę marki
        $this->vehicle->setBrand($carBrand);
        $this->assertSame($carBrand, $this->vehicle->getBrand());
    }

    public function testSetAndGetClientAddress()
    {
        $address = new Address();
        $this->vehicle->setClientAddress($address);
        $this->assertSame($address, $this->vehicle->getClientAddress());
    }

    public function testSetAndGetCurrentLocation()
    {
        $address = new Address();
        $this->vehicle->setClientAddress($address);
        $this->assertSame($address, $this->vehicle->getClientAddress());
    }
}
