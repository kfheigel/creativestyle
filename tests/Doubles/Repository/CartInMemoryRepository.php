<?php

declare(strict_types=1);

namespace App\Tests\Doubles\Repository;

use App\Domain\Entity\Cart;
use Symfony\Component\Uid\Uuid;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Repository\NonExistentEntityException;

final class CartInMemoryRepository implements CartRepositoryInterface
{
    private array $entities = [];

    public function save(Cart $cart): void
    {
        $this->entities[$cart->getId()->toRfc4122()] = $cart;
    }

    public function get(Uuid $id): Cart
    {
        $cart = $this->findOne($id);

        if (!$cart) {
            throw new NonExistentEntityException(Cart::class, $id->toRfc4122());
        }

        return $cart;
    }

    public function findOne(Uuid $id): ?Cart
    {
        return $this->entities[$id->toRfc4122()] ?? null;
    }
}
