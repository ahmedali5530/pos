<?php

namespace App\Core\Order\Query\GetOrdersListQuery;

use App\Core\Entity\Repository\EntityRepository;
use App\Entity\Order;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GetOrdersListQueryHandler extends EntityRepository implements GetOrdersListQueryHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Order::class;
    }

    public function handle(GetOrdersListQuery $query): GetOrdersListQueryResult
    {
        $qb = $this->createQueryBuilder('entity');

        $qb->leftJoin('entity.customer', 'customer');
        $qb->leftJoin('entity.tax', 'tax');
        $qb->leftJoin('entity.discount', 'discount');
        if($query->getCustomerId() !== null){
            $qb->andWhere('customer.id = :customerId');
            $qb->setParameter('customerId', $query->getCustomerId());
        }

        if($query->getUserId() !== null){
            $qb->join('entity.user', 'user');
            $qb->andWhere('user.id = :userId');
            $qb->setParameter('userId', $query->getUserId());
        }

        $qb->join('entity.items', 'items');
        if($query->getItemId() !== null){
            $qb->join('items.product', 'product');
            $qb->andWhere('product.id = :itemId');
            $qb->setParameter('itemId', $query->getItemId());
        }

        if($query->getVariantId() !== null){
            $qb->join('items.variant', 'variant');
            $qb->andWhere('variant.id = :variantId');
            $qb->setParameter('variantId', $query->getVariantId());
        }

        if($query->getOrderIds() !== null){
            $qb->andWhere('entity.entityId IN (:entityIds)');
            $qb->setParameter('entityIds', $query->getOrderIds());
        }

        if($query->getIds() !== null){
            $qb->andWhere('entity.id IN (:ids)');
            $qb->setParameter('ids', $query->getIds());
        }

        if($query->getDateTimeFrom() !== null){
            $qb->andWhere('entity.createdAt >= :dateFrom');
            $qb->setParameter('dateFrom', $query->getDateTimeFrom()->getDatetime());
        }

        if($query->getDateTimeTo() !== null){
            $qb->andWhere('entity.createdAt <= :dateTo');
            $qb->setParameter('dateTo', $query->getDateTimeTo()->getDatetime());
        }

        if($query->getQ() !== null){
            $qb->andWhere('customer.name LIKE :q OR entity.orderId LIKE :q OR entity.status LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
        }

        if($query->getStore() !== null){
            $qb->join('entity.store', 'store');
            $qb->andWhere('store.id = :store')->setParameter('store', $query->getStore());
        }

        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        if($query->getOrderBy() !== null){
            $qb->orderBy($query->getOrderBy(), $query->getOrderMode());
        }

        $list = new Paginator($qb->getQuery());

        $result = new GetOrdersListQueryResult();
        $result->setList($list);
        $result->setTotal($list->count());
        $result->setCount(count($list));
        return $result;
    }
}
