<?php

namespace App\Infrastructure\Service\Discount;

use DiscountPolicy;
use App\Domain\Entity\Cart;

class EveryFifthProductFreeDiscountPolicy implements DiscountPolicy
{
    public function apply(Cart $cart): float
    {
        $discount = 0.0;

        foreach ($cart->getCartItems() as $cartItem) {
            $quantity = $cartItem->getQuantity();
            if ($quantity >= 5) {
                $freeItems = floor($quantity / 5);
                $discount += $freeItems * $cartItem->getProduct()->getPrice();
            }
        }

        return $discount;
    }
}
