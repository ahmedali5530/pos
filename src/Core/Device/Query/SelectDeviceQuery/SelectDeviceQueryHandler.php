<?php 

namespace App\Core\Device\Query\SelectDeviceQuery;

use App\Entity\Device;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SelectDeviceQueryHandler extends EntityRepository implements SelectDeviceQueryHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(SelectDeviceQuery $query) : SelectDeviceQueryResult
    {
        $qb = $this->createQueryBuilder('Device');

        if($query->getId() !== null){
            $qb->andWhere('Device.id = :id');
            $qb->setParameter('id', $query->getId());
        }
        if($query->getIpAddress() !== null){
            $qb->andWhere('Device.ipAddress = :ipAddress');
            $qb->setParameter('ipAddress', $query->getIpAddress());
        }
        if($query->getPort() !== null){
            $qb->andWhere('Device.port = :port');
            $qb->setParameter('port', $query->getPort());
        }
        if($query->getName() !== null){
            $qb->andWhere('Device.name = :name');
            $qb->setParameter('name', $query->getName());
        }
        if($query->getPrints() !== null){
            $qb->andWhere('Device.prints = :prints');
            $qb->setParameter('prints', $query->getPrints());
        }


        if($query->getLimit() !== null){
            $qb->setMaxResults($query->getLimit());
        }

        if($query->getOffset() !== null){
            $qb->setFirstResult($query->getOffset());
        }

        $list = new Paginator($qb->getQuery());

        $result = new SelectDeviceQueryResult();
        $result->setList($list);
        $result->setCount(count($list));
        $result->setTotal($list->count());

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Device::class;
    }
}
