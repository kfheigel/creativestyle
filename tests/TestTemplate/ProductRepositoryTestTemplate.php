<?php

declare(strict_types=1);

namespace App\Tests\TestTemplate;

use App\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;
use App\Tests\Common\TestCase;
use App\Tests\Fixtures\ProductBuilder;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\ProductRepositoryInterface;

abstract class ProductRepositoryTestTemplate extends TestCase
{
    abstract protected function repository(): ProductRepositoryInterface;
    abstract protected function save(Product $product): void;

    /** @test */
    public function addAndFindOneById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';
        $givenProduct = ProductBuilder::any()
            ->withId(Uuid::fromString($givenId))
            ->build();

        // when
        $this->save($givenProduct);
        $product = $this->repository()->findOne($givenProduct->getId());
        $this->assertNotNull($product);

        // then
        self::assertEquals($givenProduct, $product);
    }

    /** @test */
    public function dontFindOneById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';

        // when
        $product = $this->repository()->findOne(Uuid::fromString($givenId));

        // then
        $this->assertNull($product);
    }

    /** @test */
    public function dontGetById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';

        // expect
        $this->expectException(NonExistentEntityException::class);

        // when
        $this->repository()->get(Uuid::fromString($givenId));
    }

    /** @test */
    public function findOneByName(): void
    {
        // given
        $givenName = 'test product';
        $givenProduct = ProductBuilder::any()
            ->withName($givenName)
            ->build();

        // when
        $this->save($givenProduct);
        $product = $this->repository()->findOneByName($givenName);
        $this->assertNotNull($product);

        // then
        self::assertEquals($givenProduct, $product);
    }


    /** @test */
    public function addFewAndFindAll(): void
    {
        // given
        $givenFirstProduct = ProductBuilder::any()->build();
        $this->save($givenFirstProduct);

        $givenSecondProduct = ProductBuilder::any()->build();
        $this->save($givenSecondProduct);

        $givenThirdProduct = ProductBuilder::any()->build();
        $this->save($givenThirdProduct);

        // when
        $products = $this->repository()->findAll();

        // then
        $this->assertNotEmpty($products);
        $this->assertCount(3, $products);
    }
}
