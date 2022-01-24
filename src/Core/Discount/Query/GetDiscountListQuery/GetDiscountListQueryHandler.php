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

        if ($query->getName() !== null) {
            $qb->andWhere('entity.name = :name');
            $qb->setParameter('name', $query->getName());
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