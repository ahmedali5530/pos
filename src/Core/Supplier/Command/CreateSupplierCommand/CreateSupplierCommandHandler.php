<?php

namespace App\Core\Supplier\Command\CreateSupplierCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Supplier;

class CreateSupplierCommandHandler extends EntityManager implements CreateSupplierCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateSupplierCommand $command) : CreateSupplierCommandResult
    {
        $item = new Supplier();

        $item->setName($command->getName());
        $item->setPhone($command->getPhone());
        $item->setEmail($command->getEmail());
        $item->setWhatsApp($command->getWhatsApp());
        $item->setFax($command->getFax());
        $item->setAddress($command->getAddress());
        $item->setOpeningBalance($command->getOpeningBalance());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateSupplierCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateSupplierCommandResult();
        $result->setSupplier($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Supplier::class;
    }
}
