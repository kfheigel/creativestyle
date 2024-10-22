<?php

declare(strict_types=1);

use App\Domain\Entity\Cart;

interface DiscountPolicy
{
    public function apply(Cart $cart): float;
}