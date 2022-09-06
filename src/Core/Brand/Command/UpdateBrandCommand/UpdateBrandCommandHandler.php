<?php

namespace App\Core\Brand\Command\UpdateBrandCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Brand;

class UpdateBrandCommandHandler extends EntityManager implements UpdateBrandCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateBrandCommand $command) : UpdateBrandCommandResult
    {
        /** @var Brand $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateBrandCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateBrandCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateBrandCommandResult();
        $result->setBrand($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Brand::class;
    }
}
