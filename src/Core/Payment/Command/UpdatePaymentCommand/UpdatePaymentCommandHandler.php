<?php

namespace App\Core\Payment\Command\UpdatePaymentCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Payment;

class UpdatePaymentCommandHandler extends EntityManager implements UpdatePaymentCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdatePaymentCommand $command) : UpdatePaymentCommandResult
    {
        /** @var Payment $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdatePaymentCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getType() !== null){
            $item->setType($command->getType());
        }
        if($command->getCanHaveChangeDue() !== null){
            $item->setCanHaveChangeDue($command->getCanHaveChangeDue());
        }

        if($command->getStores() !== null){
            foreach($item->getStores() as $store){
                $item->removeStore($store);
            }

            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdatePaymentCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdatePaymentCommandResult();
        $result->setPayment($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Payment::class;
    }
}
