<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    public function get(Uuid $id): Product;
    public function findOne(Uuid $id): ?Product;
    public function findOneByName(string $name): ?Product;
    public function findAll(): array;
}