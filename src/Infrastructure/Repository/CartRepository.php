<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Cart;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Repository\NonExistentEntityException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Cart>
 */
class CartRepository extends ServiceEntityRepository implements CartRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $cart): void
    {
        $this->getEntityManager()->persist($cart);
    }

    public function get(Uuid $id): Cart
    {
        $cart = $this->findOne($id);

        if (!$cart) {
            throw new NonExistentEntityException(Cart::class, $id->toRfc4122());
        }

        return $cart;
    }

    public function findOne(Uuid $id): ?Cart
    {
        return $this->find($id);
    }
}
