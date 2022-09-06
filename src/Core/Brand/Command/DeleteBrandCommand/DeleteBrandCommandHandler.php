<?php

namespace App\Core\Brand\Command\DeleteBrandCommand;

use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Brand;

class DeleteBrandCommandHandler extends EntityManager implements DeleteBrandCommandHandlerInterface
{
    public $validator = null;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(DeleteBrandCommand $command) : DeleteBrandCommandResult
    {
        /** @var Brand $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteBrandCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteBrandCommandResult();

        return $result;
    }

    protected function getEntityClass() : string
    {
        return Brand::class;
    }
}
