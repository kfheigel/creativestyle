<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Service\Discount;

use App\Domain\Entity\Cart;
use PHPUnit\Framework\Assert;
use App\Tests\Common\TestCase;
use App\Infrastructure\Service\Discount\EveryFifthProductFreeDiscountPolicy;

final class EveryFifthProductFreeDiscountPolicyTest extends TestCase
{
    private EveryFifthProductFreeDiscountPolicy $everyFifthProductFreeDiscountPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $everyFifthProductFreeDiscountPolicy = $this->container->get(EveryFifthProductFreeDiscountPolicy::class);
        $this->assertInstanceOf(EveryFifthProductFreeDiscountPolicy::class, $everyFifthProductFreeDiscountPolicy);
        $this->everyFifthProductFreeDiscountPolicy = $everyFifthProductFreeDiscountPolicy;
    }

    /** @test */
    public function returnNoDiscountWhenCartItemQuantityIsBelowFiveItems(): void
    {
        //given
        $cart = $this->prepareCart(
            belowFiveItems: true
        );

        //when
        $discount = $this->everyFifthProductFreeDiscountPolicy->apply($cart);
        $expectedDiscount = 0.0;

        //then
        Assert::assertEquals($expectedDiscount, $discount);
    }

    /** @test */
    public function returnDiscountWhenCartItemQuantityIsAboveFiveItems(): void
    {
        //given
        $cart = $this->prepareCart(
            belowFiveItems: false
        );

        //when
        $discount = $this->everyFifthProductFreeDiscountPolicy->apply($cart);
        $expectedDiscount = 33.0;

        //then
        Assert::assertEquals($expectedDiscount, $discount);
    }

    private function prepareCart(bool $belowFiveItems): Cart
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
            quantity: $belowFiveItems ? 1 : 5
        );
        $cartItem2 = $this->giveCartItem(
            product: $product2,
            quantity: $belowFiveItems ? 3 : 11
        );
        $cart = $this->giveCart();

        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        return $cart;
    }
}
