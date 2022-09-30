<?php

namespace App\Core\Department\Command\DeleteDepartmentCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Department;

class DeleteDepartmentCommandHandler extends EntityManager implements DeleteDepartmentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteDepartmentCommand $command) : DeleteDepartmentCommandResult
    {
        /** @var Department $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteDepartmentCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteDepartmentCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Department::class;
    }
}
