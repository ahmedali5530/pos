<?php 

namespace App\Core\Category\Command\UpdateCategoryCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Category;

class UpdateCategoryCommandHandler extends EntityManager implements UpdateCategoryCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateCategoryCommand $command) : UpdateCategoryCommandResult
    {
        /** @var Category $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return UpdateCategoryCommandResult::createNotFound();
        }

        if($command->getName() !== null){
            $item->setName($command->getName());
        }
        if($command->getType() !== null){
            $item->setType($command->getType());
        }


        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateCategoryCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateCategoryCommandResult();
        $result->setCategory($item);

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Category::class;
    }
}
