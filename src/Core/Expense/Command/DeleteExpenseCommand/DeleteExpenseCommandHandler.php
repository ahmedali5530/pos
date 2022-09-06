<?php 

namespace App\Core\Expense\Command\DeleteExpenseCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Expense;

class DeleteExpenseCommandHandler extends EntityManager implements DeleteExpenseCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteExpenseCommand $command) : DeleteExpenseCommandResult
    {
        /** @var Expense $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteExpenseCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteExpenseCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Expense::class;
    }
}
