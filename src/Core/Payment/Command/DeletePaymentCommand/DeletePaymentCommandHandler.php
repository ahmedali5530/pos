<?php 

namespace App\Core\Payment\Command\DeletePaymentCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Payment;

class DeletePaymentCommandHandler extends EntityManager implements DeletePaymentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeletePaymentCommand $command) : DeletePaymentCommandResult
    {
        /** @var Payment $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeletePaymentCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeletePaymentCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Payment::class;
    }
}
