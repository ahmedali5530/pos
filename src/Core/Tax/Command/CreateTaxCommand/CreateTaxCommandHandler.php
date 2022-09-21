<?php

namespace App\Core\Tax\Command\CreateTaxCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Tax;

class CreateTaxCommandHandler extends EntityManager implements CreateTaxCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateTaxCommand $command) : CreateTaxCommandResult
    {
        $item = new Tax();

        $item->setName($command->getName());
        $item->setRate($command->getRate());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateTaxCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateTaxCommandResult();
        $result->setTax($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Tax::class;
    }
}
