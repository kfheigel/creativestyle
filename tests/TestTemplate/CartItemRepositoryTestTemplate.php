<?php

declare(strict_types=1);

namespace App\Tests\TestTemplate;

use App\Domain\Entity\CartItem;
use Symfony\Component\Uid\Uuid;
use App\Tests\Common\TestCase;
use App\Tests\Fixtures\CartItemBuilder;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\CartItemRepositoryInterface;

abstract class CartItemRepositoryTestTemplate extends TestCase
{
    abstract protected function repository(): CartItemRepositoryInterface;
    abstract protected function save(CartItem $cartItem): void;

    /** @test */
    public function addAndFindOneById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';
        $givenCartItem = CartItemBuilder::any()
            ->withId(Uuid::fromString($givenId))
            ->build();

        // when
        $this->save($givenCartItem);
        $cartItem = $this->repository()->findOne($givenCartItem->getId());
        $this->assertNotNull($cartItem);

        // then
        self::assertEquals($givenCartItem, $cartItem);
    }

    /** @test */
    public function dontFindOneById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';

        // when
        $cartItem = $this->repository()->findOne(Uuid::fromString($givenId));

        // then
        $this->assertNull($cartItem);
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
}
