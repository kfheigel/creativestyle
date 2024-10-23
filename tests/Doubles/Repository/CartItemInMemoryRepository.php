<?php

declare(strict_types=1);

namespace App\Tests\Doubles\Repository;

use App\Domain\Entity\CartItem;
use Symfony\Component\Uid\Uuid;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\CartItemRepositoryInterface;

final class CartItemInMemoryRepository implements CartItemRepositoryInterface
{
    private array $entities = [];

    public function save(CartItem $cartItem): void
    {
        $this->entities[$cartItem->getId()->toRfc4122()] = $cartItem;
    }

    public function get(Uuid $id): CartItem
    {
        $cartItem = $this->findOne($id);

        if (!$cartItem) {
            throw new NonExistentEntityException(CartItem::class, $id->toRfc4122());
        }

        return $cartItem;
    }

    public function findOne(Uuid $id): ?CartItem
    {
        return $this->entities[$id->toRfc4122()] ?? null;
    }
}
