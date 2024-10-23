<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Controller;

use App\Domain\Entity\Cart;
use App\Domain\Entity\Product;
use App\Domain\Entity\CartItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Repository\CartItemRepositoryInterface;
use App\Infrastructure\Service\Cart\CartSummaryService;
use App\Infrastructure\Service\Sales\CartPriceCalculator;

final class SalesController extends SalesBaseController
{
    public function __construct(
        private CartPriceCalculator $cartPriceCalculator,
        private CartItemRepositoryInterface $cartItemRepository,
        private ProductRepositoryInterface $productRepository,
        private CartSummaryService $cartSummaryService
    ) {
    }

    #[Route('/products', name: 'product_list', methods: ['GET'])]
    public function listProducts(): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('cart/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/cart', name: 'cart_view', methods: ['GET'])]
    public function viewCart(Request $request): Response
    {
        $cart = $this->getCartFromSession($request);

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
            'finalPrice' => $this->cartPriceCalculator->getFinalPrice($cart),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart(Product $product, Request $request): Response
    {
        $quantity = (int)$request->request->get('quantity', 1);

        $sessionCart = $this->getCartFromSession($request);

        $cart = $this->cartSummaryService->updateCart(
            quantity: $quantity,
            cart: $sessionCart,
            product: $product
        );

        $this->saveCartToSession($request, $cart);

        return $this->redirectToRoute('cart_view');
    }

    #[Route('/cart/clear', name: 'cart_clear', methods: ['GET'])]
    public function clearCart(Request $request): Response
    {
        $this->saveCartToSession($request, new Cart());

        return $this->redirectToRoute('cart_view');
    }
}
