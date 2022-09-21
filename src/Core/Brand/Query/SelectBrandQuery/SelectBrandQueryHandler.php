<?php

namespace App\Core\Brand\Query\SelectBrandQuery;

use App\Entity\Brand;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectBrandQueryHandler extends EntityRepository implements SelectBrandQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectBrandQuery $query) : SelectBrandQueryResult
    {
        $qb = $this->createQueryBuilder('Brand');
        $qb->leftJoin('Brand.stores', 'store');

        if($query->getId() !== null){
            $qb->andWhere('Brand.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Brand.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Brand.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getQ() !== null){
            $qb->andWhere('Brand.name LIKE :q OR store.name LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
        }
        if($query->getStore() !== null){
            $qb->andWhere('store.id = :store');
            $qb->setParameter('store', $query->getStore());
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

        $result = new SelectBrandQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Brand::class;
    }
}
