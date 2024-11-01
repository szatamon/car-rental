<?php

namespace App\DataFixtures;

use App\Module\CarBrand\Entity\CarBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
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
