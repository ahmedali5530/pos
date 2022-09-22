<?php 

namespace App\Core\Closing\Command\CreateClosingCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class CreateClosingCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $closing = null;

    public function setClosing($closing)
    {
        $this->closing = $closing;
    }

    public function getClosing()
    {
        return $this->closing;
    }
}
