<?php 

namespace App\Core\Device\Command\DeleteDeviceCommand;

interface DeleteDeviceCommandHandlerInterface
{
    public function handle(DeleteDeviceCommand $command) : DeleteDeviceCommandResult;
}
