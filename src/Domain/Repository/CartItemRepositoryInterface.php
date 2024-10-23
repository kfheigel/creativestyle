<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\CartItem;
use Symfony\Component\Uid\Uuid;

interface CartItemRepositoryInterface
{
    public function save(CartItem $cartItem): void;
    public function get(Uuid $id): CartItem;
    public function findOne(Uuid $id): ?CartItem;
}
