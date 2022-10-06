<?php


namespace App\Core\Dto\Controller\Api\Admin\Product;


use App\Core\Dto\Common\Common\KeywordDto;
use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Product\Query\GetProductsKeywords\GetProductsKeywordsQueryResult;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQueryResult;

class ProductListKeywordsResponseDto
{
    /**
     * @var KeywordDto[]
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

    public static function createFromResult(GetProductsKeywordsQueryResult $list): self
    {
        $dto = new self();
        foreach ($list->getList() as $item) {
            $dto->list[] = new KeywordDto($item->getName(), $item->getId());
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
