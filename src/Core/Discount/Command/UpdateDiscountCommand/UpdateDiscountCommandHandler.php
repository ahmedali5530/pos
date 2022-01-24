<?php

namespace App\Core\Discount\Command\UpdateDiscountCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Discount;

class UpdateDiscountCommandHandler extends EntityManager implements UpdateDiscountCommandHandlerInterface
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
    
    public function handle(UpdateDiscountCommand $command): UpdateDiscountCommandResult
    {
                /** @var Discount $item */
        $item = $this->getRepository()->find($command->getId());

        if($item === null){
            return UpdateDiscountCommandResult::createNotFound();
        }
        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getRate() !== null){
            $item->setRate($command->getRate());
        }
        if($command->getRateType() !== null){
            $item->setRateType($command->getRateType());
        }

        
        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateDiscountCommandResult::createFromConstraintViolations($violations);
        }
        
        $this->persist($item);
        $this->flush();
        
        $result = new UpdateDiscountCommandResult();
        $result->setDiscount($item);
        
        return $result;
    }
}