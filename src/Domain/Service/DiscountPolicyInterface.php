<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Cart;

interface DiscountPolicyInterface
{
    public function apply(Cart $cart): float;
}
