<?php

namespace App\Core\Department\Command\UpdateDepartmentCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Department;

class UpdateDepartmentCommandHandler extends EntityManager implements UpdateDepartmentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateDepartmentCommand $command) : UpdateDepartmentCommandResult
    {
        /** @var Department $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateDepartmentCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getDescription() !== null){
            $item->setDescription($command->getDescription());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateDepartmentCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateDepartmentCommandResult();
        $result->setDepartment($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Department::class;
    }
}
