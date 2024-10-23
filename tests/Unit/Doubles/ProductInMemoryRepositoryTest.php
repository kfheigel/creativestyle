<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Tests\TestTemplate\ProductRepositoryTestTemplate;
use App\Tests\Doubles\Repository\ProductInMemoryRepository;

final class ProductInMemoryRepositoryTest extends ProductRepositoryTestTemplate
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = new ProductInMemoryRepository();
    }

    protected function repository(): ProductRepositoryInterface
    {
        return $this->productRepository;
    }

    protected function save(Product $product): void
    {
        $this->productRepository->save($product);
    }
}
