<?php

namespace App\Module\Address\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $street;

    #[ORM\Column(type: 'string', length: 100)]
    private string $city;

    #[ORM\Column(type: 'string', length: 100)]
    private string $state;

    #[ORM\Column(type: 'string', length: 50)]
    private string $zipCode;

    #[ORM\Column(type: 'string', length: 100)]
    private string $country;

    // Gettery i settery dla każdego pola
}
