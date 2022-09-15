<?php

namespace App\Core\Store\Command\CreateStoreCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Store;

class CreateStoreCommandHandler extends EntityManager implements CreateStoreCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateStoreCommand $command) : CreateStoreCommandResult
    {
        $item = new Store();

        $item->setName($command->getName());
        $item->setLocation($command->getLocation());


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateStoreCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateStoreCommandResult();
        $result->setStore($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Store::class;
    }
}
