<?php

namespace App\Core\Expense\Command\CreateExpenseCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Expense;

class CreateExpenseCommandHandler extends EntityManager implements CreateExpenseCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateExpenseCommand $command) : CreateExpenseCommandResult
    {
        $item = new Expense();

        $item->setAmount($command->getAmount());
        $item->setDescription($command->getDescription());
        $item->setCreatedAt($command->getCreatedAt());
        $item->setUser($command->getUser());
        $item->setStore($this->getRepository(Store::class)->find($command->getStore()));


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateExpenseCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateExpenseCommandResult();
        $result->setExpense($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Expense::class;
    }
}
