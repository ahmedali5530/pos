<?php

namespace App\Core\Order\Command\DeleteOrderCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteOrderCommandHandler extends EntityManager implements DeleteOrderCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Order::class;
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

    public function handle(DeleteOrderCommand $command): DeleteOrderCommandResult
    {
        /** @var Order $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DeleteOrderCommandResult::createNotFound();
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return DeleteOrderCommandResult::createFromConstraintViolations($violations);
        }

        $this->remove($item);
        $this->flush();

        $result = new DeleteOrderCommandResult();
        $result->setOrder($item);

        return $result;
    }
}