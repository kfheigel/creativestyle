<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Cart;

class Sales
{
    private array $discountPolicies;

    public function __construct(array $discountPolicies)
    {
        $this->discountPolicies = $discountPolicies;
    }

    public function getBestDiscount(Cart $cart): float
    {
        $bestDiscount = 0.0;
        
        foreach ($this->discountPolicies as $policy) {
            $discount = $policy->apply($cart);
            if ($discount > $bestDiscount) {
                $bestDiscount = $discount;
            }
        }

        return $bestDiscount;
    }

    public function getFinalPrice(Cart $cart): float
    {
        $totalPrice = $cart->getTotalPrice();
        $bestDiscount = $this->getBestDiscount($cart);

        return $totalPrice - $bestDiscount;
    }
}
