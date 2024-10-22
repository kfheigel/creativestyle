<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\CartItem;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\NonExistentEntityException;
use App\Domain\Repository\CartItemRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CartItem>
 */
class CartItemRepository extends ServiceEntityRepository implements CartItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function save(CartItem $cartItem): void
    {
        $this->getEntityManager()->persist($cartItem);
    }

    public function get(Uuid $id): CartItem
    {
        $cartItem = $this->findOne($id);

        if (!$cartItem) {
            throw new NonExistentEntityException(CartItem::class, $id->toRfc4122());
        }

        return $cartItem;
    }

    public function findOne(Uuid $id): ?CartItem
    {
        return $this->find($id);
    }
}
