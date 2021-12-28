<?php

namespace App\Repository;

use App\Entity\OrderPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderPayment[]    findAll()
 * @method OrderPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderPayment::class);
    }

    // /**
    //  * @return OrderPayment[] Returns an array of OrderPayment objects
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
    public function findOneBySomeField($value): ?OrderPayment
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
