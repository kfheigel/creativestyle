<?php

declare(strict_types=1);

namespace App\Tests\Common;

use Faker\Factory;
use Faker\Generator;
use App\Domain\Entity\Cart;
use PHPUnit\Framework\Assert;
use App\Domain\Entity\Product;
use App\Domain\Entity\CartItem;
use App\Tests\Fixtures\CartBuilder;
use App\Tests\Fixtures\ProductBuilder;
use App\Tests\Fixtures\CartItemBuilder;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Repository\CartItemRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class TestCase extends KernelTestCase
{
    protected ContainerInterface $container;
    protected ProductRepositoryInterface $productRepository;
    protected CartItemRepositoryInterface $cartItemRepository;
    protected CartRepositoryInterface $cartRepository;
    protected Generator $faker;
    protected ObjectManager $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();

        $em = $this->container->get(EntityManagerInterface::class);
        Assert::assertInstanceOf(ObjectManager::class, $em);
        $this->em = $em;

        $productRepository = $this->container->get(ProductRepositoryInterface::class);
        Assert::assertInstanceOf(ProductRepositoryInterface::class, $productRepository);
        $this->productRepository = $productRepository;

        $cartItemRepository = $this->container->get(CartItemRepositoryInterface::class);
        Assert::assertInstanceOf(CartItemRepositoryInterface::class, $cartItemRepository);
        $this->cartItemRepository = $cartItemRepository;

        $cartRepository = $this->container->get(CartRepositoryInterface::class);
        Assert::assertInstanceOf(CartRepositoryInterface::class, $cartRepository);
        $this->cartRepository = $cartRepository;

        $this->faker = Factory::create();
    }

    protected function giveProduct(string $name, float $price): Product
    {
        return ProductBuilder::any()
        ->withName($name)
        ->withPrice($price)
        ->build();
    }

    protected function giveCartItem(Product $product, int $quantity): CartItem
    {
        return CartItemBuilder::any()
        ->withProduct($product)
        ->withQuantity($quantity)
        ->build();
    }

    protected function giveCart(): Cart
    {
        return CartBuilder::any()->build();
    }
}
