<?php

namespace App\Core\Closing\Command\DeleteClosingCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Closing;

class DeleteClosingCommandHandler extends EntityManager implements DeleteClosingCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteClosingCommand $command) : DeleteClosingCommandResult
    {
        /** @var Closing $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteClosingCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteClosingCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Closing::class;
    }
}
