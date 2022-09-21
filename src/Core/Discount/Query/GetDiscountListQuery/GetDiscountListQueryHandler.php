<?php

namespace App\Core\Discount\Query\GetDiscountListQuery;

use App\Core\Entity\Repository\EntityRepository;
use App\Entity\Discount;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GetDiscountListQueryHandler extends EntityRepository implements GetDiscountListQueryHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Discount::class;
    }

    public function handle(GetDiscountListQuery $query): GetDiscountListQueryResult
    {
        $qb = $this->createQueryBuilder('entity');
        $qb->leftJoin('entity.stores', 'store');

        if ($query->getName() !== null) {
            $qb->andWhere('entity.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getStore() !== null){
            $qb->andWhere('store.id = :store');
            $qb->setParameter('store', $query->getStore());
        }
        if($query->getQ() !== null){
            $qb->andWhere('entity.name LIKE :q OR entity.rate LIKE :q OR entity.rateType LIKE :q OR entity.scope LIKE :q OR store.name LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
        }


        if($query->getOrderBy() !== null){
            $qb->orderBy($query->getOrderBy(), $query->getOrderMode());
        }

        if ($query->getLimit() !== null) {
            $qb->setMaxResults($query->getLimit());
        }

        if ($query->getOffset() !== null) {
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new GetDiscountListQueryResult();
        $result->setList($list);
        $result->setTotal($list->count());
        $result->setCount(count($list));
        return $result;
    }
}
