<?php

namespace App\Core\User\Query\SelectUserQuery;

use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectUserQueryHandler extends EntityRepository implements SelectUserQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectUserQuery $query) : SelectUserQueryResult
    {
        $qb = $this->createQueryBuilder('User');

        if($query->getId() !== null){
            $qb->andWhere('User.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getUsername() !== null){
            $qb->andWhere('User.username = :username');
            $qb->setParameter('username', $query->getUsername());
        }
        if($query->getDisplayName() !== null){
            $qb->andWhere('User.displayName LIKE :displayName');
            $qb->setParameter('displayName', '%'.$query->getDisplayName().'%');
        }
        if($query->getRoles() !== null){
            $qb->andWhere('User.roles IN(:roles)');
            $qb->setParameter('roles', $query->getRoles());
        }
        if($query->getEmail() !== null){
            $qb->andWhere('User.email = :email');
            $qb->setParameter('email', $query->getEmail());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('User.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getQ() !== null){
            $qb->andWhere(
                'User.displayName LIKE :q OR User.username = :q OR User.email LIKE :q OR store.name LIKE :q'
            );
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

        $result = new SelectUserQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return User::class;
    }
}
