<?php

namespace App\Core\Customer\Command\CreateCustomerCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Customer;

class CreateCustomerCommandHandler extends EntityManager implements CreateCustomerCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateCustomerCommand $command) : CreateCustomerCommandResult
    {
        $item = new Customer();

        $item->setName($command->getName());
        $item->setEmail($command->getEmail());
        $item->setPhone($command->getPhone());
        $item->setBirthday($command->getBirthday());
        $item->setAddress($command->getAddress());
        $item->setLat($command->getLat());
        $item->setLng($command->getLng());
        $item->setCnic($command->getCnic());
        $item->setOpeningBalance($command->getOpeningBalance());


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateCustomerCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateCustomerCommandResult();
        $result->setCustomer($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Customer::class;
    }
}
