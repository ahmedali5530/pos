<?php

namespace App\Core\Dto\Controller\Api\Admin\Device;

use App\Core\Dto\Common\Device\DeviceDto;
use App\Core\Device\Query\SelectDeviceQuery\SelectDeviceQueryResult;

class SelectDeviceListResponseDto
{
    /**
     * @var DeviceDto[]
     */
    private $list = [

    ];

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var int
     */
    private $count = 0;

    public static function createFromResult(SelectDeviceQueryResult $result) : self
    {
        $dto = new self();

        foreach($result->getList() as $list){
            $dto->list[] = DeviceDto::createFromDevice($list);
        }

        $dto->total = $result->getTotal();
        $dto->count = count($dto->list);

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
