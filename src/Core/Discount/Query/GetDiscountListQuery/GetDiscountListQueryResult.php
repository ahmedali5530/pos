<?php

namespace App\Core\Discount\Query\GetDiscountListQuery;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class GetDiscountListQueryResult
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
    
    private iterable $list = [];

    private int $count = 0;

    private int $total = 0;
    
    public function getList(): iterable
    {
        return $this->list;
    }
    
    public function setList(iterable $list): void
    {
        $this->list = $list;
    }
    
    public function getCount(): int
    {
        return $this->count;
    }
    
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }
}