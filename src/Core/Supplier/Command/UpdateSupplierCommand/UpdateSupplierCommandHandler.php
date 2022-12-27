<?php

namespace App\Core\Supplier\Command\UpdateSupplierCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Supplier;

class UpdateSupplierCommandHandler extends EntityManager implements UpdateSupplierCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateSupplierCommand $command) : UpdateSupplierCommandResult
    {
        /** @var Supplier $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateSupplierCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getPhone() !== null){
            $item->setPhone($command->getPhone());
        }
        if($command->getEmail() !== null){
            $item->setEmail($command->getEmail());
        }
        if($command->getWhatsApp() !== null){
            $item->setWhatsApp($command->getWhatsApp());
        }
        if($command->getFax() !== null){
            $item->setFax($command->getFax());
        }
        if($command->getAddress() !== null){
            $item->setAddress($command->getAddress());
        }
        if($command->getOpeningBalance() !== null){
            $item->setOpeningBalance($command->getOpeningBalance());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateSupplierCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateSupplierCommandResult();
        $result->setSupplier($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Supplier::class;
    }
}
