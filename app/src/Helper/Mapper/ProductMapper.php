<?php

namespace App\Helper\Mapper;

use App\Entity\Product;
use App\Helper\DTO\Response\ProductResponseDTO;
use Exception;

final class ProductMapper implements MapperInterface
{
    public function castEntityToDTO($entity): ProductResponseDTO
    {
        return new ProductResponseDTO($entity);
    }

    /**
     * @throws Exception
     */
    public function castEntityFromDTO($DTO, $entity = null): Product
    {
        // TODO: ошибка в нейминге переменной.
        /** @var Product $party */
        $product = $entity ?? new Product();

        $product->setName($DTO->getName());
        $product->setPrice($DTO->getPrice());
        $product->setQuantity($DTO->getQuantity());

        return $product;
    }
}
