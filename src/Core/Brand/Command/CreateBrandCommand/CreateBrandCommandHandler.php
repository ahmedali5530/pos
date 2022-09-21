<?php

namespace App\Core\Brand\Command\CreateBrandCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Brand;

class CreateBrandCommandHandler extends EntityManager implements CreateBrandCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateBrandCommand $command) : CreateBrandCommandResult
    {
        $item = new Brand();

        $item->setName($command->getName());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateBrandCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateBrandCommandResult();
        $result->setBrand($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Brand::class;
    }
}
