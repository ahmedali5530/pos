<?php

namespace App\Repository;

use App\Entity\CustomerPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomerPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerPayment[]    findAll()
 * @method CustomerPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerPayment::class);
    }

    // /**
    //  * @return CustomerPayment[] Returns an array of CustomerPayment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomerPayment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
