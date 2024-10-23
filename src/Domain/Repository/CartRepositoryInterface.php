<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Cart;
use Symfony\Component\Uid\Uuid;

interface CartRepositoryInterface
{
    public function save(Cart $cart): void;
    public function get(Uuid $id): Cart;
    public function findOne(Uuid $id): ?Cart;
}
