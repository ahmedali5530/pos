<?php 

namespace App\Core\Payment\Query\SelectPaymentQuery;

use App\Entity\Payment;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectPaymentQueryHandler extends EntityRepository implements SelectPaymentQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectPaymentQuery $query) : SelectPaymentQueryResult
    {
        $qb = $this->createQueryBuilder('Payment');

        if($query->getId() !== null){
            $qb->andWhere('Payment.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Payment.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getType() !== null){
            $qb->andWhere('Payment.type = :type');
            $qb->setParameter('type', $query->getType());
        }
        if($query->getCanHaveChangeDue() !== null){
            $qb->andWhere('Payment.canHaveChangeDue = :canHaveChangeDue');
            $qb->setParameter('canHaveChangeDue', $query->getCanHaveChangeDue());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Payment.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getCreatedAt() !== null){
            $qb->andWhere('Payment.createdAt = :createdAt');
            $qb->setParameter('createdAt', $query->getCreatedAt());
        }
        if($query->getDeletedAt() !== null){
            $qb->andWhere('Payment.deletedAt = :deletedAt');
            $qb->setParameter('deletedAt', $query->getDeletedAt());
        }
        if($query->getUpdatedAt() !== null){
            $qb->andWhere('Payment.updatedAt = :updatedAt');
            $qb->setParameter('updatedAt', $query->getUpdatedAt());
        }
        if($query->getUuid() !== null){
            $qb->andWhere('Payment.uuid = :uuid');
            $qb->setParameter('uuid', $query->getUuid());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectPaymentQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Payment::class;
    }
}
