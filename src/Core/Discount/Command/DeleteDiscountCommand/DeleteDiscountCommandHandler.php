<?php

namespace App\Core\Discount\Command\DeleteDiscountCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Discount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteDiscountCommandHandler extends EntityManager implements DeleteDiscountCommandHandlerInterface
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

    public function handle(DeleteDiscountCommand $command): DeleteDiscountCommandResult
    {
        /** @var Discount $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteDiscountCommandResult::createNotFound();
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return DeleteDiscountCommandResult::createFromConstraintViolations($violations);
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteDiscountCommandResult();
        $result->setDiscount($item);

        return $result;
    }
}