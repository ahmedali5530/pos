<?php

namespace App\Repository;

use App\Entity\OrderTax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderTax|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderTax|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderTax[]    findAll()
 * @method OrderTax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderTaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderTax::class);
    }

    // /**
    //  * @return OrderTax[] Returns an array of OrderTax objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderTax
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
