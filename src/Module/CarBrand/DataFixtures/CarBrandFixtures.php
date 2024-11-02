<?php

namespace App\Module\CarBrand\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Module\CarBrand\Entity\CarBrand;

class CarBrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            'Toyota',
            'Honda',
            'Ford',
            'Chevrolet',
            'Mercedes-Benz',
            'BMW',
            'Audi',
            'Volkswagen',
            'Nissan',
            'Hyundai'
        ];

        foreach ($brands as $brandName) {
            $brand = new CarBrand();
            $brand->setName($brandName);
            $manager->persist($brand);
        }

        $manager->flush();
    }
}