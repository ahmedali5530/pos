<?php

namespace App\Core\Terminal\Command\UpdateTerminalCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Terminal;

class UpdateTerminalCommandHandler extends EntityManager implements UpdateTerminalCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateTerminalCommand $command) : UpdateTerminalCommandResult
    {
        /** @var Terminal $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateTerminalCommandResult::createNotFound();
        }

        if($command->getCode() !== null){
            $item->setCode($command->getCode());
        }
        if($command->getDescription() !== null){
            $item->setDescription($command->getDescription());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateTerminalCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateTerminalCommandResult();
        $result->setTerminal($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Terminal::class;
    }
}
