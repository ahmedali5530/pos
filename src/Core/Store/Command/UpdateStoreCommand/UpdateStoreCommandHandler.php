<?php

namespace App\Core\Store\Command\UpdateStoreCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Store;

class UpdateStoreCommandHandler extends EntityManager implements UpdateStoreCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateStoreCommand $command) : UpdateStoreCommandResult
    {
        /** @var Store $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateStoreCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getLocation() !== null){
            $item->setLocation($command->getLocation());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateStoreCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateStoreCommandResult();
        $result->setStore($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Store::class;
    }
}
