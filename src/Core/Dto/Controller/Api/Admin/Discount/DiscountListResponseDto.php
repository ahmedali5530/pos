<?php


namespace App\Core\Dto\Controller\Api\Admin\Discount;


use App\Core\Discount\Query\GetDiscountListQuery\GetDiscountListQueryResult;
use App\Core\Dto\Common\Discount\DiscountDto;

class DiscountListResponseDto
{
    /**
     * @var DiscountDto[]
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

    public static function createFromQueryResult(GetDiscountListQueryResult $result): self
    {
        $dto = new self();
        foreach($result->getList() as $list){
            $dto->list[] = DiscountDto::createFromDiscount($list);
        }

        $dto->total = $result->getTotal();
        $dto->count = count($dto->list);

        return $dto;
    }


    /**
     * @return DiscountDto[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param DiscountDto[] $list
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
