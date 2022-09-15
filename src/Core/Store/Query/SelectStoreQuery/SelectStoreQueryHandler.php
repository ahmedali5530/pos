<?php

namespace App\Core\Store\Query\SelectStoreQuery;

use App\Entity\Store;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectStoreQueryHandler extends EntityRepository implements SelectStoreQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectStoreQuery $query) : SelectStoreQueryResult
    {
        $qb = $this->createQueryBuilder('Store');

        if($query->getId() !== null){
            $qb->andWhere('Store.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Store.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getLocation() !== null){
            $qb->andWhere('Store.location = :location');
            $qb->setParameter('location', $query->getLocation());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Store.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getQ() !== null){
            $qb->andWhere('Store.name LIKE :q OR Store.location LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
        }

        if($query->getOrderBy() !== null){
            $qb->orderBy($query->getOrderBy(), $query->getOrderMode());
        }

        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectStoreQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Store::class;
    }
}
