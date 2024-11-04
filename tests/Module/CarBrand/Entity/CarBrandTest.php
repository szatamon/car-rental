<?php

namespace Tests\Module\CarBrand\Entity;

use App\Module\CarBrand\Entity\CarBrand;
use PHPUnit\Framework\TestCase;

class CarBrandTest extends TestCase
{
    private CarBrand $carBrand;

    protected function setUp(): void
    {
        $this->carBrand = new CarBrand();
    }

    public function testGetId()
    {
        $reflection = new \ReflectionClass($this->carBrand);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($this->carBrand, 1);

        $this->assertEquals(1, $this->carBrand->getId());
    }

    public function testSetAndGetName()
    {
        $this->carBrand->setName('Test Brand');
        $this->assertEquals('Test Brand', $this->carBrand->getName());
    }

    public function testSetNameUpdatesValue()
    {
        $this->carBrand->setName('Initial Brand');
        $this->assertEquals('Initial Brand', $this->carBrand->getName());

        $this->carBrand->setName('Updated Brand');
        $this->assertEquals('Updated Brand', $this->carBrand->getName());
    }
}
