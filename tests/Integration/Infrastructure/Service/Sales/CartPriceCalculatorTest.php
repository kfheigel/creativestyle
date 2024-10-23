<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Service\Sales;

use App\Domain\Entity\Cart;
use PHPUnit\Framework\Assert;
use App\Tests\Common\TestCase;
use App\Infrastructure\Service\Sales\CartPriceCalculator;

final class CartPriceCalculatorTest extends TestCase
{
    private CartPriceCalculator $cartPriceCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $cartPriceCalculator = $this->container->get(CartPriceCalculator::class);
        $this->assertInstanceOf(CartPriceCalculator::class, $cartPriceCalculator);
        $this->cartPriceCalculator = $cartPriceCalculator;
    }

    /** @test */
    public function returnTotalPriceWith10PercentDiscountWhenCartTotalPriceIsAboveThreshold(): void
    {
        //given
        $cart = $this->prepareCart(
            aboveThreshold: true
        );

        //when
        $finalPrice = $this->cartPriceCalculator->getFinalPrice($cart);
        $expectedTotalPrice = 135;

        //then
        Assert::assertEquals($expectedTotalPrice, $finalPrice);
    }

    /** @test */
    public function returnTotalPriceWithoutDiscountWhenCartTotalPriceIsBelowThreshold(): void
    {
        //given
        $cart = $this->prepareCart(
            aboveThreshold: false
        );

        //when
        $finalPrice = $this->cartPriceCalculator->getFinalPrice($cart);
        $expectedTotalPrice = 75;

        //then
        Assert::assertEquals($expectedTotalPrice, $finalPrice);
    }

    /** @test */
    public function returnTotalPriceWithFiveItemsDiscount(): void
    {
        //given
        $cart = $this->prepareCartWithFiveProducts();

        //when
        $finalPrice = $this->cartPriceCalculator->getFinalPrice($cart);
        $expectedTotalPrice = 360;

        //then
        Assert::assertEquals($expectedTotalPrice, $finalPrice);
    }

    private function prepareCart(bool $aboveThreshold): Cart
    {
        $product1 = $this->giveProduct(
            name: 'Test Product 1',
            price: 20.0
        );
        $product2 = $this->giveProduct(
            name: 'Test Product 2',
            price: 35.0
        );

        $cartItem1 = $this->giveCartItem(
            product: $product1,
            quantity: $aboveThreshold ? 4 : 2
        );
        $cartItem2 = $this->giveCartItem(
            product: $product2,
            quantity: $aboveThreshold ? 2 : 1
        );
        $cart = $this->giveCart();

        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        return $cart;
    }


    private function prepareCartWithFiveProducts(): Cart
    {
        $product1 = $this->giveProduct(
            name: 'Test Product 1',
            price: 20.0
        );
        $product2 = $this->giveProduct(
            name: 'Test Product 2',
            price: 35.0
        );

        $cartItem1 = $this->giveCartItem(
            product: $product1,
            quantity: 5
        );
        $cartItem2 = $this->giveCartItem(
            product: $product2,
            quantity: 10
        );
        $cart = $this->giveCart();

        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        return $cart;
    }
}
