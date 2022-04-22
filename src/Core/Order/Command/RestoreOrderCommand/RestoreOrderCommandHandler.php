<?php

namespace App\Core\Order\Command\RestoreOrderCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RestoreOrderCommandHandler extends EntityManager implements RestoreOrderCommandHandlerInterface
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

    public function handle(RestoreOrderCommand $command): RestoreOrderCommandResult
    {
        /** @var Order $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return RestoreOrderCommandResult::createNotFound();
        }

        $item->setIsDeleted(null);
        $item->setStatus(OrderStatus::COMPLETED);

        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return RestoreOrderCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new RestoreOrderCommandResult();
        $result->setOrder($item);

        return $result;
    }
}