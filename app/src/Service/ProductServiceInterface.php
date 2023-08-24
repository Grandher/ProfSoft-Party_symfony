<?php

namespace App\Service;

use App\Entity\Product;
use App\Helper\DTO\CRUD\ProductDTO;
use App\Helper\DTO\Response\ProductResponseDTO;

interface ProductServiceInterface extends ServiceInterface
{
    public function create(ProductDTO $DTO): ProductResponseDTO;

    public function update(ProductDTO $DTO, Product $product): ProductResponseDTO;
}
