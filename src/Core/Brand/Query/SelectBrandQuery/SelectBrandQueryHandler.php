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
