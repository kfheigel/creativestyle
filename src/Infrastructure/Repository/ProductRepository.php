<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
    }

    public function get(Uuid $id): Product
    {
        $product = $this->findOne($id);

        if (!$product) {
            throw new NonExistentEntityException(Product::class, $id->toRfc4122());
        }

        return $product;
    }

    public function findOne(Uuid $id): ?Product
    {
        return $this->find($id);
    }

    public function findOneByName(string $name): ?Product
    {
        /** @var Product|null $product */
        $product = $this->findOneBy(["name" => $name]);

        return $product;
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }
}
