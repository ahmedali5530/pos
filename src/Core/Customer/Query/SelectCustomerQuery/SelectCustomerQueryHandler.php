<?php 

namespace App\Core\Customer\Query\SelectCustomerQuery;

use App\Entity\Customer;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectCustomerQueryHandler extends EntityRepository implements SelectCustomerQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectCustomerQuery $query) : SelectCustomerQueryResult
    {
        $qb = $this->createQueryBuilder('Customer');

        if($query->getId() !== null){
            $qb->andWhere('Customer.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Customer.name LIKE :name');
            $qb->setParameter('name', $query->getName().'%');
        }
        if($query->getEmail() !== null){
            $qb->andWhere('Customer.email = :email');
            $qb->setParameter('email', $query->getEmail());
        }
        if($query->getPhone() !== null){
            $qb->andWhere('Customer.phone = :phone');
            $qb->setParameter('phone', $query->getPhone());
        }
        if($query->getBirthday() !== null){
            $qb->andWhere('Customer.birthday = :birthday');
            $qb->setParameter('birthday', $query->getBirthday());
        }
        if($query->getAddress() !== null){
            $qb->andWhere('Customer.address = :address');
            $qb->setParameter('address', $query->getAddress());
        }
        if($query->getLat() !== null){
            $qb->andWhere('Customer.lat = :lat');
            $qb->setParameter('lat', $query->getLat());
        }
        if($query->getLng() !== null){
            $qb->andWhere('Customer.lng = :lng');
            $qb->setParameter('lng', $query->getLng());
        }
        if($query->getCreatedAt() !== null){
            $qb->andWhere('Customer.createdAt = :createdAt');
            $qb->setParameter('createdAt', $query->getCreatedAt());
        }
        if($query->getDeletedAt() !== null){
            $qb->andWhere('Customer.deletedAt = :deletedAt');
            $qb->setParameter('deletedAt', $query->getDeletedAt());
        }
        if($query->getUpdatedAt() !== null){
            $qb->andWhere('Customer.updatedAt = :updatedAt');
            $qb->setParameter('updatedAt', $query->getUpdatedAt());
        }
        if($query->getUuid() !== null){
            $qb->andWhere('Customer.uuid = :uuid');
            $qb->setParameter('uuid', $query->getUuid());
        }

        if($query->getQ() !== null){
            $qb->andWhere('Customer.name LIKE :q OR Customer.phone LIKE :q OR Customer.cnic LIKE :q');
            $qb->setParameter('q', $query->getQ().'%');
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectCustomerQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Customer::class;
    }
}
