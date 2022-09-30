<?php

namespace App\Core\Closing\Command\UpdateClosingCommand;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Closing;

class UpdateClosingCommandHandler extends EntityManager implements UpdateClosingCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateClosingCommand $command) : UpdateClosingCommandResult
    {
        /** @var Closing $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateClosingCommandResult::createNotFound();
        }

        if($command->getDateFrom() !== null){
            $item->setDateFrom($command->getDateFrom());
        }
        if($command->getDateTo() !== null){
            $item->setDateTo($command->getDateTo());
        }
        if($command->getClosedAt() !== null){
            $item->setClosedAt($command->getClosedAt());
        }
        if($command->getOpeningBalance() !== null){
            $item->setOpeningBalance($command->getOpeningBalance());
        }
        if($command->getClosingBalance() !== null){
            $item->setClosingBalance($command->getClosingBalance());
        }
        if($command->getCashAdded() !== null){
            $item->setCashAdded($command->getCashAdded());
        }
        if($command->getCashWithdrawn() !== null){
            $item->setCashWithdrawn($command->getCashWithdrawn());
        }
        if($command->getData() !== null){
            $item->setData($command->getData());
        }
        if($command->getDenominations() !== null){
            $item->setDenominations($command->getDenominations());
        }
        if($command->getExpenses() !== null){
            $item->setExpenses($command->getExpenses());
        }
        if($command->getClosedBy() !== null){
            $closedBy = $this->getRepository(User::class)->find($command->getClosedBy());
            $item->setClosedBy($closedBy);
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateClosingCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateClosingCommandResult();
        $result->setClosing($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Closing::class;
    }
}
