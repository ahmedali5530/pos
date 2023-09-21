<?php

namespace App\Core\Product\Query\GetProductsKeywords;

use App\Core\Entity\Repository\EntityRepository;
use App\Entity\Product;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GetProductsKeywordsQueryHandler extends EntityRepository implements GetProductsKeywordsQueryHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    public function handle(GetProductsKeywordsQuery $query): GetProductsKeywordsQueryResult
    {
        $qb = $this->createQueryBuilder('product');

        if($query->getName() !== null){
            $qb->andWhere('product.name LIKE :name');
            $qb->setParameter('name', '%'.$query->getName().'%');
        }

        if($query->getItemId() !== null){
            $qb->andWhere('product.id = :itemId');
            $qb->setParameter('itemId', $query->getItemId());
        }

        if($query->getItemIds() !== null){
            $qb->andWhere('product.id IN(:itemIds)');
            $qb->setParameter('itemIds', $query->getItemIds());
        }

        if($query->getVariantId() !== null){
            $qb->join('product.variants', 'variant');
            $qb->andWhere('variant.id = :variantId');
            $qb->setParameter('variantId', $query->getVariantId());
        }

        $qb->andWhere('product.isActive = :true');
        $qb->setParameter('true', true);

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

        $result = new GetProductsKeywordsQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }
}
