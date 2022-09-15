<?php

namespace App\Core\User\Command\DeleteUserCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;

class DeleteUserCommandHandler extends EntityManager implements DeleteUserCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteUserCommand $command) : DeleteUserCommandResult
    {
        /** @var User $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteUserCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteUserCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return User::class;
    }
}
