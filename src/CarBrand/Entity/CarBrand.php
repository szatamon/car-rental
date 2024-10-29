<?php

namespace App\Module\CarBrand\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class CarBrand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $name;

    // Gettery i settery dla każdego pola
}
