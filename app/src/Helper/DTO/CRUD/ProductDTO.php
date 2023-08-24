<?php

namespace App\Helper\DTO\CRUD;

use Symfony\Component\Serializer\Annotation\Groups;

final class ProductDTO
{
    #[Groups(['create'])]
    public string $name;

    #[Groups(['create'])]
    public int $price;

    #[Groups(['create'])]
    public float $quantity;


    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }
}
