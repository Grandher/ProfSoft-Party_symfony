<?php

namespace App\Helper\DTO\Response;

use App\Entity\Product;
use Symfony\Component\Serializer\Annotation\Groups;

// TODO: comment readonly
final class ProductResponseDTO
{
    #[Groups(['getList'])]
    public readonly int $id;

    #[Groups(['getList'])]
    public string $name;

    #[Groups(['getList'])]
    public int $price;

    #[Groups(['getList'])]
    public float $quantity;

    public function __construct(Product $product)
    {
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->quantity = $product->getQuantity();
    }
}
