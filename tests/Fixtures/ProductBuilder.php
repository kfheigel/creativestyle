<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Faker\Factory;
use App\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;

final class ProductBuilder
{
    private Uuid $id;
    private string $name;
    private float $price;

    public function withId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public static function any(): self
    {
        return new ProductBuilder();
    }

    public function build(): Product
    {
        $faker = Factory::create();

        return new Product(
            $this->name ?? $faker->name(),
            $this->price ?? $faker->randomFloat(),
            $this->id ?? Uuid::v4()
        );
    }
}
