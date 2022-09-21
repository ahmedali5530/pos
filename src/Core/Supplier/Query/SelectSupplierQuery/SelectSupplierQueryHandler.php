<?php

namespace App\Core\Supplier\Query\SelectSupplierQuery;

use App\Entity\Supplier;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectSupplierQueryHandler extends EntityRepository implements SelectSupplierQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectSupplierQuery $query) : SelectSupplierQueryResult
    {
        $qb = $this->createQueryBuilder('Supplier');
        $qb->leftJoin('Supplier.stores', 'store');

        if($query->getId() !== null){
            $qb->andWhere('Supplier.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Supplier.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getPhone() !== null){
            $qb->andWhere('Supplier.phone = :phone');
            $qb->setParameter('phone', $query->getPhone());
        }
        if($query->getEmail() !== null){
            $qb->andWhere('Supplier.email = :email');
            $qb->setParameter('email', $query->getEmail());
        }
        if($query->getWhatsApp() !== null){
            $qb->andWhere('Supplier.whatsApp = :whatsApp');
            $qb->setParameter('whatsApp', $query->getWhatsApp());
        }
        if($query->getFax() !== null){
            $qb->andWhere('Supplier.fax = :fax');
            $qb->setParameter('fax', $query->getFax());
        }
        if($query->getAddress() !== null){
            $qb->andWhere('Supplier.address = :address');
            $qb->setParameter('address', $query->getAddress());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Supplier.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getQ() !== null){
            $qb->andWhere('Supplier.name LIKE :q OR Supplier.phone LIKE :q OR Supplier.email LIKE :q OR store.name LIKE :q');
            $qb->setParameter('q', '%'.$query->getQ().'%');
        }
        if($query->getStore() !== null){
            $qb->andWhere('store.id = :store');
            $qb->setParameter('store', $query->getStore());
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

        $result = new SelectSupplierQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Supplier::class;
    }
}
