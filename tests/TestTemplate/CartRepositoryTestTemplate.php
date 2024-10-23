<?php

declare(strict_types=1);

namespace App\Tests\TestTemplate;

use App\Domain\Entity\Cart;
use Symfony\Component\Uid\Uuid;
use App\Tests\Common\TestCase;
use App\Tests\Fixtures\CartBuilder;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\CartRepositoryInterface;

abstract class CartRepositoryTestTemplate extends TestCase
{
    abstract protected function repository(): CartRepositoryInterface;
    abstract protected function save(Cart $cart): void;

    /** @test */
    public function addAndFindOneById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';
        $givenCart = CartBuilder::any()
            ->withId(Uuid::fromString($givenId))
            ->build();

        // when
        $this->save($givenCart);
        $cart = $this->repository()->findOne($givenCart->getId());
        $this->assertNotNull($cart);

        // then
        self::assertEquals($givenCart, $cart);
    }

    /** @test */
    public function dontFindOneById(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';

        // when
        $cart = $this->repository()->findOne(Uuid::fromString($givenId));

        // then
        $this->assertNull($cart);
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
