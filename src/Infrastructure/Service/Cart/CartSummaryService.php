<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cart;

use App\Domain\Entity\Cart;
use App\Domain\Entity\Product;
use App\Domain\Entity\CartItem;

final class CartSummaryService
{
    public function updateCart(
        int $quantity,
        Cart $cart,
        Product $product
    ): Cart {
        $foundItem = null;
        foreach ($cart->getCartItems() as $cartItem) {
            if ($cartItem->getProduct()?->getId() == $product->getId()) {
                $foundItem = $cartItem;
                break;
            }
        }

        if ($foundItem) {
            $foundItem->setQuantity($foundItem->getQuantity() + $quantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $cart->addCartItem($cartItem);
        }

        return $cart;
    }
}
