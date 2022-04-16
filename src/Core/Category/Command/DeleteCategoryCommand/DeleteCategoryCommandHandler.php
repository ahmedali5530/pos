<?php 

namespace App\Core\Category\Command\DeleteCategoryCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Category;

class DeleteCategoryCommandHandler extends EntityManager implements DeleteCategoryCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteCategoryCommand $command) : DeleteCategoryCommandResult
    {
        /** @var Category $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteCategoryCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteCategoryCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Category::class;
    }
}
