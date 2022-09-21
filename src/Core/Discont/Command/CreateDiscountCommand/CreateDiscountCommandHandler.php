<?php

namespace App\Core\Discont\Command\CreateDiscountCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Discount;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateDiscountCommandHandler extends EntityManager implements CreateDiscountCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Discount::class;
    }

    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateDiscountCommand $command): CreateDiscountCommandResult
    {
        $item = new Discount();
        $item->setName($command->getName());
        $item->setRate($command->getRate());
        $item->setRateType($command->getRateType());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return CreateDiscountCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateDiscountCommandResult();
        $result->setDiscount($item);

        return $result;
    }
}
