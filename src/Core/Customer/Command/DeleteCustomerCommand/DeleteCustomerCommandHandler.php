<?php 

namespace App\Core\Customer\Command\DeleteCustomerCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Customer;

class DeleteCustomerCommandHandler extends EntityManager implements DeleteCustomerCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteCustomerCommand $command) : DeleteCustomerCommandResult
    {
        /** @var Customer $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteCustomerCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteCustomerCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Customer::class;
    }
}
