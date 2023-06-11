<?php

namespace App\Repository;

use App\Entity\SupplierPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SupplierPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupplierPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupplierPayment[]    findAll()
 * @method SupplierPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupplierPayment::class);
    }

    // /**
    //  * @return SupplierPayment[] Returns an array of SupplierPayment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SupplierPayment
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
