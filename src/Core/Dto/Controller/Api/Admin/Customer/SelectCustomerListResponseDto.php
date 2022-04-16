<?php 

namespace App\Core\Dto\Controller\Api\Admin\Customer;

use App\Core\Dto\Common\Customer\CustomerDto;
use App\Core\Customer\Query\SelectCustomerQuery\SelectCustomerQueryResult;

class SelectCustomerListResponseDto
{
    /**
     * @var CustomerDto[]
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

    public static function createFromResult(SelectCustomerQueryResult $result) : self
    {
        $dto = new self();

        foreach($result->getList() as $list){
            $dto->list[] = CustomerDto::createFromCustomer($list);
        }

        $dto->total = $result->getTotal();
        $dto->count = $result->getCount();

        return $dto;
    }

    public function setList($list)
    {
        $this->list = $list;
    }

    public function getList()
    {
        return $this->list;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getCount()
    {
        return $this->count;
    }
}
