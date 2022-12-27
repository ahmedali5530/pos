<?php

namespace App\Core\Order\Command\CreateOrderCommand;

use App\Core\Dto\Common\Order\OrderDiscountDto;
use App\Core\Entity\EntityManager\EntityManager;
use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\OrderDiscount;
use App\Entity\OrderPayment;
use App\Entity\OrderProduct;
use App\Entity\OrderStatus;
use App\Entity\OrderTax;
use App\Entity\Payment;
use App\Entity\Product;
use App\Entity\ProductVariant;
use App\Entity\Store;
use App\Entity\Tax;
use App\Entity\Terminal;
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

        $item->setDescription($command->getNotes());

        $item->setStatus(OrderStatus::HOLD);
        if(!$command->getIsSuspended()) {
            $item->setOrderId($this->getNewOrderId());
            $item->setStatus(OrderStatus::COMPLETED);
        }

        if($command->getReturnedFrom() !== null) {
            $item->setReturnedFrom(
                $this->getRepository(Order::class)->find($command->getReturnedFrom())
            );
        }
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

        $item->setStore($this->getRepository(Store::class)->find($command->getStore()));
        $item->setTerminal($this->getRepository(Terminal::class)->find($command->getTerminal()));

        $item->setAdjustment($command->getAdjustment());

        foreach($command->getItems() as $itemDto){
            $orderProduct = new OrderProduct();
            $orderProduct->setProduct($this->getRepository(Product::class)->find($itemDto->getProduct()->getId()));
            $orderProduct->setDiscount($itemDto->getDiscount());
            $orderProduct->setPrice($itemDto->getPrice());
            $orderProduct->setQuantity($itemDto->getQuantity());

            if($itemDto->getVariant() !== null) {
                $orderProduct->setVariant($this->getRepository(ProductVariant::class)->find($itemDto->getVariant()->getId()));
            }

            if($itemDto->getTaxes()){
                foreach($itemDto->getTaxes() as $tax){
                    $t = $this->getRepository(Tax::class)->find($tax->getId());

                    $orderProduct->addTax($t);
                }
            }

            $item->addItem($orderProduct);
        }

        $orderTotal = 0;
        if(null !== $payments = $command->getPayments()){
            foreach($payments as $paymentDto){
                $payment = new OrderPayment();
                $payment->setTotal($paymentDto->getTotal());
                $payment->setType(
                    $this->getRepository(Payment::class)->find($paymentDto->getType()->getId())
                );
                $payment->setDue($paymentDto->getDue());
                $payment->setReceived($paymentDto->getReceived());

                $orderTotal += $paymentDto->getTotal();

                $item->addPayment($payment);
            }
        }

        if(null !== $command->getDiscount()){
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
                ->select('COALESCE(MAX(entity.orderId) + 1, 1)')
                ->getQuery()->getSingleScalarResult();
        }catch (\Exception $exception){
            return 1;
        }
    }
}
