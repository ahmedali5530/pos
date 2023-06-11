<?php

namespace App\Repository;

use App\Entity\PurchaseOrderItemVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PurchaseOrderItemVariant|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseOrderItemVariant|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseOrderItemVariant[]    findAll()
 * @method PurchaseOrderItemVariant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseOrderItemVariantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchaseOrderItemVariant::class);
    }

    // /**
    //  * @return PurchaseOrderItemVariant[] Returns an array of PurchaseOrderItemVariant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PurchaseOrderItemVariant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
