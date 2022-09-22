<?php

namespace App\Core\Closing\Command\CreateClosingCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Closing;

class CreateClosingCommandHandler extends EntityManager implements CreateClosingCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateClosingCommand $command) : CreateClosingCommandResult
    {
        $item = new Closing();

        $item->setDateFrom($command->getDateFrom());
        $item->setDateTo($command->getDateTo());
        $item->setClosedAt($command->getClosedAt());
        $item->setOpeningBalance($command->getOpeningBalance());
        $item->setClosingBalance($command->getClosingBalance());
        $item->setCashAdded($command->getCashAdded());
        $item->setCashWithdrawn($command->getCashWithdrawn());
        $item->setData($command->getData());
        $item->setDenominations($command->getDenominations());


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateClosingCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateClosingCommandResult();
        $result->setClosing($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Closing::class;
    }
}
