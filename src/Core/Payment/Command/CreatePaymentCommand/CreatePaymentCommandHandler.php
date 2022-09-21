<?php

namespace App\Core\Payment\Command\CreatePaymentCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Payment;

class CreatePaymentCommandHandler extends EntityManager implements CreatePaymentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreatePaymentCommand $command) : CreatePaymentCommandResult
    {
        $item = new Payment();

        $item->setName($command->getName());
        $item->setType($command->getType());
        $item->setCanHaveChangeDue($command->getCanHaveChangeDue());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreatePaymentCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreatePaymentCommandResult();
        $result->setPayment($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Payment::class;
    }
}
