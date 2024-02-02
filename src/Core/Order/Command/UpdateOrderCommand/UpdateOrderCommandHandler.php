<?php

namespace App\Core\Order\Command\UpdateOrderCommand;

use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\OrderDiscount;
use App\Entity\OrderPayment;
use App\Entity\OrderTax;
use App\Entity\Payment;
use App\Entity\Tax;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Entity\EntityManager\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Order;

class UpdateOrderCommandHandler extends EntityManager implements UpdateOrderCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        return Order::class;
    }

    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        parent::__construct($entityManager);
        $this->validator = $validator;
    }

    public function handle(UpdateOrderCommand $command): UpdateOrderCommandResult
    {
        /** @var Order $item */
        $item = $this->getRepository()->find($command->getId());

        if($item === null){
            return UpdateOrderCommandResult::createNotFound();
        }
        if($command->getCustomerId() !== null) {
            $item->setCustomer(
                $this->getRepository(Customer::class)->find($command->getCustomerId())
            );
        }

        if($command->getCustomer() !== null){
            $item->setCustomer(
                (new Customer())->setName($command->getCustomer())
            );
        }

        if($command->getStatus() !== null){
            $item->setStatus($command->getStatus());
        }

        if($command->getDescription() !== null){
            $item->setDescription($command->getDescription());
        }

        if($command->getAdjustment() !== null){
            $item->setAdjustment($command->getAdjustment());
        }

        if(null !== $payments = $command->getPayments()){
            // delete previous payments
            $prevPayments = $this->getRepository(OrderPayment::class)->findBy([
                'order' => $item
            ]);
            $this->removeAll($prevPayments);

            foreach($payments as $paymentDto){
                $payment = new OrderPayment();
                $payment->setTotal($paymentDto->getTotal());
                $payment->setType(
                    $this->getRepository(Payment::class)->find($paymentDto->getType()->getId())
                );
                $payment->setDue($paymentDto->getDue());
                $payment->setReceived($paymentDto->getReceived());

                $item->addPayment($payment);
            }
        }

        if(null !== $command->getDiscount()){
            // delete previous discount
            $prevDiscount = $this->getRepository(OrderDiscount::class)->findOneBy([
                'order' => $item
            ]);
            if($prevDiscount !== null){
                $this->remove($prevDiscount);
                $this->flush();
            }

            /** @var Discount $discount */
            $discount = $this->getRepository(Discount::class)->find($command->getDiscount()->getId());

            $orderDiscount = new OrderDiscount();
            $orderDiscount->setAmount($command->getDiscountAmount());
            $orderDiscount->setRate($command->getDiscount()->getRate());
            $orderDiscount->setType($discount);
            $orderDiscount->setOrder($item);
            $orderDiscount->setRateType($command->getDiscountRateType());

            $this->persist($orderDiscount);

            $item->setDiscount($orderDiscount);
        }

        if(null !== $command->getTax()){
            $prevTax = $this->getRepository(OrderTax::class)->findOneBy([
                'order' => $item
            ]);
            if($prevTax !== null){
                $this->remove($prevTax);
                $this->flush();
            }

            /** @var Tax $tax */
            $tax = $this->getRepository(Tax::class)->find($command->getTax()->getId());
            $orderTax = new OrderTax();
            $orderTax->setType($tax);
            $orderTax->setOrder($item);
            $orderTax->setRate($command->getTax()->getRate());
            $orderTax->setAmount($command->getTaxAmount());
            $this->persist($orderTax);

            $item->setTax($orderTax);
        }

        //validate item before creation
        $violations = $this->validator->validate($item);
        if($violations->count() > 0){
            return UpdateOrderCommandResult::createFromConstraintViolations($violations);
        }

        $this->persist($item);
        $this->flush();

        $result = new UpdateOrderCommandResult();
        $result->setOrder($item);

        return $result;
    }
}
