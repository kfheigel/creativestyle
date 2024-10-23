<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Discount;

use App\Domain\Entity\Cart;
use App\Domain\Service\DiscountPolicyInterface;

final class PercentageDiscountPolicy implements DiscountPolicyInterface
{
    private float $threshold;
    private float $percentage;

    public function __construct(float $threshold = 100, float $percentage = 10)
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
