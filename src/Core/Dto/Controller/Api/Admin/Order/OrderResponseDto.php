<?php


namespace App\Core\Dto\Controller\Api\Admin\Order;


use App\Core\Dto\Common\Order\OrderDto;
use App\Entity\Order;

class OrderResponseDto
{
    /**
     * @var OrderDto|null
     */
    private $order;

    public static function createFromOrder(Order $order): self
    {
        $dto = new self();

        $dto->order = OrderDto::createFromOrder($order);

        return $dto;
    }


    /**
     * @return OrderDto|null
     */
    public function getOrder(): ?OrderDto
    {
        return $this->order;
    }

    /**
     * @param OrderDto|null $order
     */
    public function setOrder(?OrderDto $order): void
    {
        $this->order = $order;
    }
}