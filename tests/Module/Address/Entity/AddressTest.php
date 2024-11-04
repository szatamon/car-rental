<?php

namespace Tests\Module\Address\Entity;

use App\Module\Address\Entity\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    private Address $address;

    protected function setUp(): void
    {
        $this->address = new Address();
    }

    public function testGetId()
    {
        $reflection = new \ReflectionClass($this->address);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($this->address, 1);

        $this->assertEquals(1, $this->address->getId());
    }

    public function testSetAndGetStreet()
    {
        $this->address->setStreet('123 Main St');
        $this->assertEquals('123 Main St', $this->address->getStreet());
    }

    public function testSetAndGetCity()
    {
        $this->address->setCity('Springfield');
        $this->assertEquals('Springfield', $this->address->getCity());
    }

    public function testSetAndGetState()
    {
        $this->address->setState('IL');
        $this->assertEquals('IL', $this->address->getState());
    }

    public function testSetAndGetZipCode()
    {
        $this->address->setZipCode('62704');
        $this->assertEquals('62704', $this->address->getZipCode());
    }

    public function testSetAndGetCountry()
    {
        $this->address->setCountry('USA');
        $this->assertEquals('USA', $this->address->getCountry());
    }
}
