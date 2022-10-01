<?php

namespace App\Core\Terminal\Command\CreateTerminalCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Terminal;

class CreateTerminalCommandHandler extends EntityManager implements CreateTerminalCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateTerminalCommand $command) : CreateTerminalCommandResult
    {
        $item = new Terminal();

        $item->setCode($command->getCode());
        $item->setDescription($command->getDescription());


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateTerminalCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateTerminalCommandResult();
        $result->setTerminal($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Terminal::class;
    }
}
