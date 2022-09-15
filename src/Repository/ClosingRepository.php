<?php

namespace App\Repository;

use App\Entity\Closing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Closing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Closing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Closing[]    findAll()
 * @method Closing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClosingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Closing::class);
    }

    // /**
    //  * @return Closing[] Returns an array of Closing objects
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
    public function findOneBySomeField($value): ?Closing
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
