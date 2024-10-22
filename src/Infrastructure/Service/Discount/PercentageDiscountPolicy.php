<?php

namespace App\Infrastructure\Service\Discount;

use DiscountPolicy;
use App\Domain\Entity\Cart;

class PercentageDiscountPolicy implements DiscountPolicy
{
    private float $threshold;
    private float $percentage;

    public function __construct(float $threshold, float $percentage)
    {
        $this->threshold = $threshold;
        $this->percentage = $percentage;
    }

    public function apply(Cart $cart): float
    {
        $totalPrice = $cart->getTotalPrice();
        if ($totalPrice > $this->threshold) {
            return $totalPrice * ($this->percentage / 100);
        }

        return 0.0;
    }
}
