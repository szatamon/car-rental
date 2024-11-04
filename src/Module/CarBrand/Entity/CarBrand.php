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

    // Getter dla id
    public function getId(): int
    {
        return $this->id;
    }

    // Getter dla name
    public function getName(): string
    {
        return $this->name;
    }

    // Setter dla name
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
