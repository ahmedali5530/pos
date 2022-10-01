<?php 

namespace App\Core\Terminal\Command\UpdateTerminalCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class UpdateTerminalCommandResult
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
