<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\CartItem;
use App\Domain\Repository\CartItemRepositoryInterface;
use App\Tests\TestTemplate\CartItemRepositoryTestTemplate;
use App\Tests\Doubles\Repository\CartItemInMemoryRepository;

final class CartItemInMemoryRepositoryTest extends CartItemRepositoryTestTemplate
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->cartItemRepository = new CartItemInMemoryRepository();
    }

    protected function repository(): CartItemRepositoryInterface
    {
        return $this->cartItemRepository;
    }

    protected function save(CartItem $cartItem): void
    {
        $this->cartItemRepository->save($cartItem);
    }
}
