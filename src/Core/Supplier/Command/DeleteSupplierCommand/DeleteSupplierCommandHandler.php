<?php

namespace App\Core\Supplier\Command\DeleteSupplierCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Supplier;

class DeleteSupplierCommandHandler extends EntityManager implements DeleteSupplierCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteSupplierCommand $command) : DeleteSupplierCommandResult
    {
        /** @var Supplier $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteSupplierCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteSupplierCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Supplier::class;
    }
}
