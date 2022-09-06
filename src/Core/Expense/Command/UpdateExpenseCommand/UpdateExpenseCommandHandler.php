<?php 

namespace App\Core\Expense\Command\UpdateExpenseCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Expense;

class UpdateExpenseCommandHandler extends EntityManager implements UpdateExpenseCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateExpenseCommand $command) : UpdateExpenseCommandResult
    {
        /** @var Expense $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateExpenseCommandResult::createNotFound();
        }

        if($command->getAmount() !== null){
            $item->setAmount($command->getAmount());
        }
        if($command->getDescription() !== null){
            $item->setDescription($command->getDescription());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateExpenseCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateExpenseCommandResult();
        $result->setExpense($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Expense::class;
    }
}
