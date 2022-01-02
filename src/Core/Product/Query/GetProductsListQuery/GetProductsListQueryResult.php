<?php

namespace App\Core\Product\Query\GetProductsListQuery;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Entity\Product;

class GetProductsListQueryResult
{
    use CqrsResultEntityNotFoundTrait;

    private iterable $list = [];

    private int $count = 0;

    private int $total = 0;

    /**
     * @return Product[]
     */
    public function getList(): iterable
    {
        return $this->list;
    }

    /**
     * @param Product[] $list
     */
    public function setList(iterable $list): void
    {
        $this->list = $list;
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
}