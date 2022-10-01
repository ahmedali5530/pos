<?php

namespace App\Core\Terminal\Command\DeleteTerminalCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Terminal;

class DeleteTerminalCommandHandler extends EntityManager implements DeleteTerminalCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteTerminalCommand $command) : DeleteTerminalCommandResult
    {
        /** @var Terminal $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteTerminalCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteTerminalCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Terminal::class;
    }
}
