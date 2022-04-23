<?php

namespace App\Core\Order\Command\RefundOrderCommand;

use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RefundOrderCommandHandler extends EntityManager implements RefundOrderCommandHandlerInterface
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

    public function handle(RefundOrderCommand $command): RefundOrderCommandResult
    {
        /** @var Order $item */
        $item = $this->getRepository()->find($command->getId());

        if ($item === null) {
            return RefundOrderCommandResult::createNotFound();
        }

        $item->setStatus(OrderStatus::RETURNED);
        $item->setIsReturned(true);

        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return RefundOrderCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new RefundOrderCommandResult();
        $result->setOrder($item);

        return $result;
    }
}