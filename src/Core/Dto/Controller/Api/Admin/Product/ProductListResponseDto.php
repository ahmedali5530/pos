<?php


namespace App\Core\Dto\Controller\Api\Admin\Product;


use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQueryResult;

class ProductListResponseDto
{
    /**
     * @var ProductDto[]
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

    public static function createFromResult(GetProductsListQueryResult $list): self
    {
        $dto = new self();
        foreach ($list->getList() as $item) {
            $dto->list[] = ProductDto::createFromProduct($item);
        }

        $dto->total = $list->getTotal();
        $dto->count = count($dto->list);

        return $dto;
    }

    /**
     * @return ProductDto[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param ProductDto[] $list
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
