<?php

namespace App\Core\Expense\Query\SelectExpenseQuery;

use App\Entity\Expense;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectExpenseQueryHandler extends EntityRepository implements SelectExpenseQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectExpenseQuery $query) : SelectExpenseQueryResult
    {
        $qb = $this->createQueryBuilder('Expense');

        if($query->getId() !== null){
            $qb->andWhere('Expense.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getAmount() !== null){
            $qb->andWhere('Expense.amount = :amount');
            $qb->setParameter('amount', $query->getAmount());
        }
        if($query->getDescription() !== null){
            $qb->andWhere('Expense.description = :description');
            $qb->setParameter('description', $query->getDescription());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Expense.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getDateTimeFrom() !== null){
            $qb->andWhere('Expense.createdAt >= :dateTimeFrom');
            $qb->setParameter('dateTimeFrom', $query->getDateTimeFrom()->getDatetime());
        }
        if($query->getDateTimeTo() !== null){
            $qb->andWhere('Expense.createdAt <= :dateTimeTo');
            $qb->setParameter('dateTimeTo', $query->getDateTimeTo()->getDatetime());
        }
        if($query->getStore() !== null){
            $qb->join('Expense.store', 'store');
            $qb->andWhere('store.id = :store')->setParameter('store', $query->getStore());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectExpenseQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Expense::class;
    }
}
