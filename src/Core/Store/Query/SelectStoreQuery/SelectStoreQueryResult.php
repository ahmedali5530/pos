<?php 

namespace App\Core\Store\Query\SelectStoreQuery;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class SelectStoreQueryResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $list = null;

    public $count = null;

    public $total = null;

    public function setList($list)
    {
        $this->list = $list;
    }

    public function getList()
    {
        return $this->list;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
