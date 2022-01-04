<?php


namespace App\Core\Dto\Controller\Api\Admin\Order;


use App\Core\Dto\Common\Order\OrderDto;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQueryResult;

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


    public static function createFromResult(GetOrdersListQueryResult $result): self
    {
        $dto = new self();
        foreach($result->getList() as $item){
            $dto->list[] = OrderDto::createFromOrder($item);
        }

        $dto->total = $result->getTotal();
        $dto->count = $result->getCount();

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
}