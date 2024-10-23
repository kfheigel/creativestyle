<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Controller;

use App\Domain\Entity\Cart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalesBaseController extends AbstractController
{
    protected function getCartFromSession(Request $request): Cart
    {
        /** @var Cart $cart */
        $cart = $request->getSession()->get('cart', new Cart());

        return $cart;
    }

    protected function saveCartToSession(Request $request, Cart $cart): void
    {
        $request->getSession()->set('cart', $cart);
    }
}
