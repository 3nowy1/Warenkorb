<?php

namespace App\Repository;

use App\DTO\CartDTO;
use App\Entity\ShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingCart>
 *
 * @method ShoppingCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCart[]    findAll()
 * @method ShoppingCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCart::class);
    }

    public function saveShoppingCart(ShoppingCart $shoppingCart): ShoppingCart
    {
        $em = $this->getEntityManager();
        $em->persist($shoppingCart);
        $em->flush();

        return $shoppingCart;
    }

    public function removeShoppingCart(ShoppingCart $shoppingCart): void
    {
        $em = $this->getEntityManager();
        $em->remove($shoppingCart);
        $em->flush();
    }
}
