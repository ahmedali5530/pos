<?php

namespace App\Core\Category\Command\CreateCategoryCommand;

use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Category;

class CreateCategoryCommandHandler extends EntityManager implements CreateCategoryCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(CreateCategoryCommand $command) : CreateCategoryCommandResult
    {
        $item = new Category();

        $item->setName($command->getName());
        $item->setType($command->getType());

        if($command->getStores() !== null){
            foreach($command->getStores() as $store){
                $s = $this->getRepository(Store::class)->find($store);
                $item->addStore($s);
            }
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return CreateCategoryCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateCategoryCommandResult();
        $result->setCategory($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Category::class;
    }
}
