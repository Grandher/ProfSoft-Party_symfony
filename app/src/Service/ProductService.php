<?php

namespace App\Service;

use App\Entity\Product;
use App\Helper\DTO\Response\ProductResponseDTO;
use App\Helper\Mapper\MapperInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MapperInterface        $mapper,
    )
    {
    }

    public function getList(): array
    {
        $productEntities = $this->entityManager->getRepository(Product::class)->findAll();

        $productDTOs = [];

        foreach ($productEntities as $product) {
            $productDTOs[] = $this->mapper->castEntityToDTO($product);
        }

        return $productDTOs;
    }

    public function create($DTO): ProductResponseDTO
    {
        return $this->mapper->castEntityFromDTO($DTO);
    }

    public function update($DTO, Product $product): ProductResponseDTO
    {
        return $this->mapper->castEntityFromDTO($DTO, $product);
    }

    public function delete($entityId): void
    {
        $product = $this->entityManager->getRepository(Product::class)->find($entityId);

        $this->entityManager->remove($product);
    }
}
