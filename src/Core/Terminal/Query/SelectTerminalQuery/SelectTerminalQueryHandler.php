<?php

namespace App\Core\Terminal\Query\SelectTerminalQuery;

use App\Entity\Terminal;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectTerminalQueryHandler extends EntityRepository implements SelectTerminalQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectTerminalQuery $query) : SelectTerminalQueryResult
    {
        $qb = $this->createQueryBuilder('Terminal');

        if($query->getId() !== null){
            $qb->andWhere('Terminal.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getCode() !== null){
            $qb->andWhere('Terminal.code = :code');
            $qb->setParameter('code', $query->getCode());
        }
        if($query->getDescription() !== null){
            $qb->andWhere('Terminal.description = :description');
            $qb->setParameter('description', $query->getDescription());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Terminal.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getQ() !== null){
            $qb->andWhere('Terminal.code LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
        }

        if($query->getOrderBy() !== null){
            $qb->orderBy($query->getOrderBy(), $query->getOrderMode());
        }

        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectTerminalQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Terminal::class;
    }
}
