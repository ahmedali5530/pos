<?php


namespace App\Core\Dto\Controller\Api\Admin\Order;


use App\Core\Dto\Common\Order\OrderDto;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQueryResult;
use App\Entity\Order;
use App\Entity\OrderPayment;
use App\Entity\Payment;

class OrderListResponseDto
{
    /**
     * @var OrderDto[]
     */
    private $list = [];

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var int
     */
    private $count = 0;

    /**
     * @var string[]
     */
    private $payments = [];


    public static function createFromResult(GetOrdersListQueryResult $result): self
    {
        $dto = new self();
        foreach($result->getList() as $item){
            $dto->list[] = OrderDto::createFromOrder($item);
        }

        $dto->total = $result->getTotal();
        $dto->count = count($dto->list);

        //calculate payment types
        $cash = 0;
        $payments = [];
        /** @var Order $item */
        foreach($result->getList() as $item){
            foreach($item->getPayments() as $payment){
                if($payment->getType()->getType() === Payment::PAYMENT_TYPE_CASH){
                    $cash += $payment->getTotal();
                }else{
                    if(!isset($payments[$payment->getType()->getType()])){
                        $payments[$payment->getType()->getType()] = 0;
                    }
                    $payments[$payment->getType()->getType()] += $payment->getTotal();
                }
            }
        }

        $payments['cash'] = $cash;
        $dto->payments = $payments;

        return $dto;
    }

    /**
     * @return OrderDto[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param OrderDto[] $list
     */
    public function setList(array $list): void
    {
        $this->list = $list;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return string[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param string[] $payments
     */
    public function setPayments(array $payments): void
    {
        $this->payments = $payments;
    }
}
