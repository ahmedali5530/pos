<?php 

namespace App\Core\Device\Command\DeleteDeviceCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class DeleteDeviceCommandResult
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
