<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\Domain\Entity\Cart;
use Symfony\Component\Uid\Uuid;

final class CartBuilder
{
    private Uuid $id;

    public function withId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public static function any(): self
    {
        return new CartBuilder();
    }

    public function build(): Cart
    {
        $cart = new Cart(
            $this->id ?? Uuid::v4()
        );

        return $cart;
    }
}
