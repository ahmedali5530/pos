<?php

namespace App\Core\Dto\Controller\Api\Admin\Terminal;

use App\Core\Dto\Common\Terminal\TerminalDto;
use App\Entity\Terminal;

class SelectTerminalResponseDto
{
    /**
     * @var TerminalDto
     */
    private $terminal = null;

    public static function createFromTerminal(Terminal $terminal) : self
    {
        $dto = new self();

        $dto->terminal = TerminalDto::createFromTerminal($terminal);

        return $dto;
    }

    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;
    }

    public function getTerminal()
    {
        return $this->terminal;
    }
}
