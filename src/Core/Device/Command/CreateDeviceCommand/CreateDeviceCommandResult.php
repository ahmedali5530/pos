<?php 

namespace App\Core\Device\Command\CreateDeviceCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class CreateDeviceCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $device = null;

    public function setDevice($device)
    {
        $this->device = $device;
    }

    public function getDevice()
    {
        return $this->device;
    }
}
