<?php 

namespace App\Core\Terminal\Command\DeleteTerminalCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class DeleteTerminalCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $terminal = null;

    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;
    }

    public function getTerminal()
    {
        return $this->terminal;
    }
}
