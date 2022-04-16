<?php 

namespace App\Core\Category\Query\SelectCategoryQuery;

use App\Entity\Category;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectCategoryQueryHandler extends EntityRepository implements SelectCategoryQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectCategoryQuery $query) : SelectCategoryQueryResult
    {
        $qb = $this->createQueryBuilder('Category');

        if($query->getId() !== null){
            $qb->andWhere('Category.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getName() !== null){
            $qb->andWhere('Category.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getType() !== null){
            $qb->andWhere('Category.type = :type');
            $qb->setParameter('type', $query->getType());
        }
        if($query->getIsActive() !== null){
            $qb->andWhere('Category.isActive = :isActive');
            $qb->setParameter('isActive', $query->getIsActive());
        }
        if($query->getCreatedAt() !== null){
            $qb->andWhere('Category.createdAt = :createdAt');
            $qb->setParameter('createdAt', $query->getCreatedAt());
        }
        if($query->getDeletedAt() !== null){
            $qb->andWhere('Category.deletedAt = :deletedAt');
            $qb->setParameter('deletedAt', $query->getDeletedAt());
        }
        if($query->getUpdatedAt() !== null){
            $qb->andWhere('Category.updatedAt = :updatedAt');
            $qb->setParameter('updatedAt', $query->getUpdatedAt());
        }
        if($query->getUuid() !== null){
            $qb->andWhere('Category.uuid = :uuid');
            $qb->setParameter('uuid', $query->getUuid());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectCategoryQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Category::class;
    }
}
