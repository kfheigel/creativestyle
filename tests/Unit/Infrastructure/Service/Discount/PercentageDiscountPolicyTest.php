<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Service\Discount;

use App\Domain\Entity\Cart;
use PHPUnit\Framework\Assert;
use App\Tests\Common\TestCase;
use App\Infrastructure\Service\Discount\PercentageDiscountPolicy;

final class PercentageDiscountPolicyTest extends TestCase
{
    private PercentageDiscountPolicy $percentageDiscountPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $percentageDiscountPolicy = $this->container->get(PercentageDiscountPolicy::class);
        $this->assertInstanceOf(PercentageDiscountPolicy::class, $percentageDiscountPolicy);
        $this->percentageDiscountPolicy = $percentageDiscountPolicy;
    }

    /** @test */
    public function returnNoDiscountWhenCartTotalPriceIsBelowThreshold(): void
    {
        //given
        $cart = $this->prepareCart(
            belowThreshold: true
        );

        //when
        $discount = $this->percentageDiscountPolicy->apply($cart);
        $expectedDiscount = 0.0;

        //then
        Assert::assertEquals($expectedDiscount, $discount);
    }

    /** @test */
    public function returnDiscountWhenCartTotalPriceIsAboveThreshold(): void
    {
        //given
        $cart = $this->prepareCart(
            belowThreshold: false
        );

        //when
        $discount = $this->percentageDiscountPolicy->apply($cart);
        $expectedDiscount = 13.0;

        //then
        Assert::assertEquals($expectedDiscount, $discount);
    }

    private function prepareCart(bool $belowThreshold): Cart
    {
        $product1 = $this->giveProduct(
            name: 'Test Product 1',
            price: 23.0
        );
        $product2 = $this->giveProduct(
            name: 'Test Product 2',
            price: 5.0
        );

        $cartItem1 = $this->giveCartItem(
            product: $product1,
            quantity: $belowThreshold ? 1 : 5
        );
        $cartItem2 = $this->giveCartItem(
            product: $product2,
            quantity: 3
        );
        $cart = $this->giveCart();

        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        return $cart;
    }
}
