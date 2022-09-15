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
        $qb->leftJoin('product.categories', 'category');
        $qb->leftJoin('product.suppliers', 'supplier');
        $qb->leftJoin('product.brands', 'brand');

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

        if($query->getQ() !== null){
            $qb->andWhere('product.name LIKE :q OR product.barcode LIKE :q OR product.basePrice LIKE :q OR product.cost LIKE :q OR supplier.name LIKE :q OR category.name LIKE :q OR brand.name LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
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

        $result = new GetProductsListQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }
}
