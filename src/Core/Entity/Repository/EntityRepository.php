<?php


namespace App\Core\Entity\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;

abstract class EntityRepository
{
    protected $em;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->em = $entityManager;
    }

    abstract protected function getEntityClass(): string;

    public function getRepository($class = null): ObjectRepository
    {
        if($class === null){
            $class = $this->getEntityClass();
        }

        return $this->em->getRepository($class);
    }

    public function createQueryBuilder(string $alias, $class = null): QueryBuilder
    {
        return $this->getRepository($class)->createQueryBuilder($alias);
    }
}