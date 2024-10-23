<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\Cart;
use App\Domain\Repository\CartRepositoryInterface;
use App\Tests\TestTemplate\CartRepositoryTestTemplate;
use App\Tests\Doubles\Repository\CartInMemoryRepository;

final class CartInMemoryRepositoryTest extends CartRepositoryTestTemplate
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = new CartInMemoryRepository();
    }

    protected function repository(): CartRepositoryInterface
    {
        return $this->cartRepository;
    }

    protected function save(Cart $cart): void
    {
        $this->cartRepository->save($cart);
    }
}
