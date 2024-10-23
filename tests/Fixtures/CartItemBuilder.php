<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Faker\Factory;
use App\Domain\Entity\Product;
use App\Domain\Entity\CartItem;
use Symfony\Component\Uid\Uuid;

final class CartItemBuilder
{
    private Uuid $id;
    private Product $product;
    private int $quantity;

    public function withId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function withQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public static function any(): self
    {
        return new CartItemBuilder();
    }

    public function build(): CartItem
    {
        $faker = Factory::create();

        $cartItem = new CartItem(
            $this->id ?? Uuid::v4()
        );
        $cartItem->setProduct(
            $this->product ?? ProductBuilder::any()->build()
        );

        $cartItem->setQuantity(
            $this->quantity ?? $faker->randomDigitNotZero()
        );


        return $cartItem;
    }
}
