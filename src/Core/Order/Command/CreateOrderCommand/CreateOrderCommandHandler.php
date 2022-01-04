<?php

namespace App\Core\Order\Command\CreateOrderCommand;

use App\Core\Dto\Common\Order\OrderDiscountDto;
use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\OrderDiscount;
use App\Entity\OrderPayment;
use App\Entity\OrderTax;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateOrderCommandHandler extends EntityManager implements CreateOrderCommandHandlerInterface
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

    public function handle(CreateOrderCommand $command): CreateOrderCommandResult
    {
        $item = new Order();

        $item->setOrderId($this->getNewOrderId());
        $item->setIsSuspended($command->getIsSuspended());
        $item->setIsDeleted($command->getIsDeleted());
        $item->setIsReturned($command->getIsReturned());
        $item->setIsDispatched($command->getIsDispatched());
        if($command->getCustomerId() !== null) {
            $item->setCustomer(
                $this->getRepository(Customer::class)->find($command->getCustomerId())
            );
        }

        $item->setUser(
          $this->getRepository(User::class)->find($command->getUserId())
        );

        foreach($command->getItems() as $itemDto){
            $item->addItem(
                $this->getRepository(Product::class)->find($itemDto->getProduct()->getId())
            );
        }

        if(null !== $discount = $command->getDiscount()){
            $item->setDiscount(
                $this->getRepository(OrderDiscount::class)->find($discount->getId())
            );
        }

        if(null !== $tax = $command->getTax()){
            $item->setTax(
                $this->getRepository(OrderTax::class)->find($tax->getId())
            );
        }

        if(null !== $payments = $command->getPayments()){
            foreach($payments as $paymentDto){
                $item->addPayment(
                    $this->getRepository(OrderPayment::class)->find($paymentDto->getId())
                );
            }
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if ($violations->count() > 0) {
            return CreateOrderCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new CreateOrderCommandResult();
        $result->setOrder($item);

        return $result;
    }

    public function getNewOrderId(): string
    {
        try{
            return $this->createQueryBuilder('entity')
                ->select('MAX(entity.orderId) + 1')
                ->getQuery()->getSingleScalarResult();
        }catch (\Exception $exception){
            return 1;
        }
    }
}