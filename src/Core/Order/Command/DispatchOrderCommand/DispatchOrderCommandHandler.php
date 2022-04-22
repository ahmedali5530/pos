<?php

namespace App\Core\Order\Command\DispatchOrderCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DispatchOrderCommandHandler extends EntityManager implements DispatchOrderCommandHandlerInterface
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

    public function handle(DispatchOrderCommand $command): DispatchOrderCommandResult
    {
        /** @var Order $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return DispatchOrderCommandResult::createNotFound();
        }

        $item->setStatus(OrderStatus::DISPATCHED);
        $item->setIsDispatched(true);

        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return DispatchOrderCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new DispatchOrderCommandResult();
        $result->setOrder($item);

        return $result;
    }
}