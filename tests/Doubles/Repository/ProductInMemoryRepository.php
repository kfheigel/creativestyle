<?php

declare(strict_types=1);

namespace App\Tests\Doubles\Repository;

use App\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\ProductRepositoryInterface;

final class ProductInMemoryRepository implements ProductRepositoryInterface
{
    private array $entities = [];

    public function save(Product $product): void
    {
        $this->entities[$product->getId()->toRfc4122()] = $product;
    }

    public function get(Uuid $id): Product
    {
        $product = $this->findOne($id);

        if (!$product) {
            throw new NonExistentEntityException(Product::class, $id->toRfc4122());
        }

        return $product;
    }

    public function findOne(Uuid $id): ?Product
    {
        return $this->entities[$id->toRfc4122()] ?? null;
    }

    public function findOneByName(string $name): ?Product
    {
        foreach ($this->entities as $id => $product) {
            $found = true;

            if ($product->getName() !== $name) {
                $found = false;
            }

            if ($found) {
                return $this->entities[$id];
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return $this->entities;
    }
}
