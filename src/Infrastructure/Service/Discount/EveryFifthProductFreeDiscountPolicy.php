<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Discount;

use App\Domain\Entity\Cart;
use App\Domain\Service\DiscountPolicyInterface;

final class EveryFifthProductFreeDiscountPolicy implements DiscountPolicyInterface
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
