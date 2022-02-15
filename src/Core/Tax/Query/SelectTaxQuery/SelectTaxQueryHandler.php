<?php 

namespace App\Core\Tax\Query\SelectTaxQuery;

use App\Entity\Tax;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectTaxQueryHandler extends EntityRepository implements SelectTaxQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectTaxQuery $query) : SelectTaxQueryResult
    {
        $qb = $this->createQueryBuilder('Tax');

        if($query->getId() !== null){
            $qb->andWhere('Tax.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Tax.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getRate() !== null){
            $qb->andWhere('Tax.rate = :rate');
            $qb->setParameter('rate', $query->getRate());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Tax.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getCreatedAt() !== null){
            $qb->andWhere('Tax.createdAt = :createdAt');
            $qb->setParameter('createdAt', $query->getCreatedAt());
        }
        if($query->getDeletedAt() !== null){
            $qb->andWhere('Tax.deletedAt = :deletedAt');
            $qb->setParameter('deletedAt', $query->getDeletedAt());
        }
        if($query->getUpdatedAt() !== null){
            $qb->andWhere('Tax.updatedAt = :updatedAt');
            $qb->setParameter('updatedAt', $query->getUpdatedAt());
        }
        if($query->getUuid() !== null){
            $qb->andWhere('Tax.uuid = :uuid');
            $qb->setParameter('uuid', $query->getUuid());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectTaxQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Tax::class;
    }
}
