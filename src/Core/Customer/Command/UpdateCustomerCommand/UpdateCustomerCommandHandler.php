<?php

namespace App\Core\Customer\Command\UpdateCustomerCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Customer;

class UpdateCustomerCommandHandler extends EntityManager implements UpdateCustomerCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateCustomerCommand $command) : UpdateCustomerCommandResult
    {
        /** @var Customer $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateCustomerCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getEmail() !== null){
            $item->setEmail($command->getEmail());
        }
        if($command->getPhone() !== null){
            $item->setPhone($command->getPhone());
        }
        if($command->getBirthday() !== null){
            $item->setBirthday($command->getBirthday());
        }
        if($command->getAddress() !== null){
            $item->setAddress($command->getAddress());
        }
        if($command->getLat() !== null){
            $item->setLat($command->getLat());
        }
        if($command->getLng() !== null){
            $item->setLng($command->getLng());
        }
        if($command->getOpeningBalance() !== null){
            $item->setOpeningBalance($command->getOpeningBalance());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateCustomerCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateCustomerCommandResult();
        $result->setCustomer($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Customer::class;
    }
}
