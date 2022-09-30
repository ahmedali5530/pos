<?php

namespace App\Core\Department\Query\SelectDepartmentQuery;

use App\Entity\Department;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectDepartmentQueryHandler extends EntityRepository implements SelectDepartmentQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectDepartmentQuery $query) : SelectDepartmentQueryResult
    {
        $qb = $this->createQueryBuilder('Department');

        if($query->getId() !== null){
            $qb->andWhere('Department.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Department.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getDescription() !== null){
            $qb->andWhere('Department.description LIKE :description');
            $qb->setParameter('description', '%'.$query->getDescription().'%');
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Department.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectDepartmentQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Department::class;
    }
}
