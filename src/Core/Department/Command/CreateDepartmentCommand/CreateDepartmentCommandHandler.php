<?php

namespace App\Core\Department\Command\CreateDepartmentCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Department;

class CreateDepartmentCommandHandler extends EntityManager implements CreateDepartmentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateDepartmentCommand $command) : CreateDepartmentCommandResult
    {
        $item = new Department();

        $item->setName($command->getName());
        $item->setDescription($command->getDescription());


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateDepartmentCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateDepartmentCommandResult();
        $result->setDepartment($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Department::class;
    }
}
