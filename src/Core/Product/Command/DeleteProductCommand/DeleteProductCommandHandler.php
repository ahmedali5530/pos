<?php

namespace App\Core\Product\Command\DeleteProductCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteProductCommandHandler extends EntityManager implements DeleteProductCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Product::class;
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

    public function handle(DeleteProductCommand $command): DeleteProductCommandResult
    {
        /** @var Product $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteProductCommandResult::createNotFound();
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteProductCommandResult();

        return $result;
    }
}