<?php

namespace App\Core\Dto\Controller\Api\Admin\Terminal;

use App\Core\Dto\Common\Terminal\TerminalDto;
use App\Core\Terminal\Query\SelectTerminalQuery\SelectTerminalQueryResult;
use Symfony\Component\Serializer\Annotation\Groups;

class SelectTerminalListResponseDto
{
    /**
     * @var TerminalDto[]
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

    public static function createFromResult(SelectTerminalQueryResult $result) : self
    {
        $dto = new self();

        foreach($result->getList() as $list){
            $dto->list[] = TerminalDto::createFromTerminal($list);
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
