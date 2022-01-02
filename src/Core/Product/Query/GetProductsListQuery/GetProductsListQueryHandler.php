<?php

namespace App\Core\Product\Query\GetProductsListQuery;

use App\Core\Entity\Repository\EntityRepository;
use App\Entity\Product;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GetProductsListQueryHandler extends EntityRepository implements GetProductsListQueryHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }
    
    public function handle(GetProductsListQuery $query): GetProductsListQueryResult
    {
        $qb = $this->createQueryBuilder('product');
        $qb->leftJoin('product.category', 'category');

        if($query->getName() !== null){
            $qb->andWhere('product.name LIKE :name');
            $qb->setParameter('name', '%'.$query->getName().'%');
        }

        if(null !== $categoryId = $query->getCategoryId()){
            $qb->andWhere('category.id = :categoryId');
            $qb->setParameter('categoryId', $categoryId);
        }

        if(null !== $categoryName = $query->getCategoryName()){
            $qb->andWhere('category.name LIKE :categoryName');
            $qb->setParameter('categoryName', '%'.$categoryName.'%');
        }

        if(null !== $priceFrom = $query->getPriceFrom()){
            $qb->andWhere('product.price >= :priceFrom');
            $qb->setParameter('priceFrom', $priceFrom);
        }

        if(null !== $priceTo = $query->getPriceTo()){
            $qb->andWhere('product.price <= :priceTo');
            $qb->setParameter('priceTo', $priceTo);
        }

        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new GetProductsListQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }
}