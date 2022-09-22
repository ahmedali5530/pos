<?php

namespace App\Core\Closing\Query\SelectClosingQuery;

use App\Entity\Closing;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectClosingQueryHandler extends EntityRepository implements SelectClosingQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectClosingQuery $query) : SelectClosingQueryResult
    {
        $qb = $this->createQueryBuilder('Closing');

        if($query->getId() !== null){
            $qb->andWhere('Closing.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getDateFrom() !== null){
            $qb->andWhere('Closing.dateFrom = :dateFrom');
            $qb->setParameter('dateFrom', $query->getDateFrom());
        }
        if($query->getDateTo() !== null){
            $qb->andWhere('Closing.dateTo = :dateTo');
            $qb->setParameter('dateTo', $query->getDateTo());
        }
        if($query->getClosedAt() !== null){
            $qb->andWhere('Closing.closedAt = :closedAt');
            $qb->setParameter('closedAt', $query->getClosedAt());
        }
        if($query->getOpeningBalance() !== null){
            $qb->andWhere('Closing.openingBalance = :openingBalance');
            $qb->setParameter('openingBalance', $query->getOpeningBalance());
        }
        if($query->getClosingBalance() !== null){
            $qb->andWhere('Closing.closingBalance = :closingBalance');
            $qb->setParameter('closingBalance', $query->getClosingBalance());
        }
        if($query->getCashAdded() !== null){
            $qb->andWhere('Closing.cashAdded = :cashAdded');
            $qb->setParameter('cashAdded', $query->getCashAdded());
        }
        if($query->getCashWithdrawn() !== null){
            $qb->andWhere('Closing.cashWithdrawn = :cashWithdrawn');
            $qb->setParameter('cashWithdrawn', $query->getCashWithdrawn());
        }
        if($query->getData() !== null){
            $qb->andWhere('Closing.data = :data');
            $qb->setParameter('data', $query->getData());
        }
        if($query->getDenominations() !== null){
            $qb->andWhere('Closing.denominations = :denominations');
            $qb->setParameter('denominations', $query->getDenominations());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectClosingQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Closing::class;
    }
}
