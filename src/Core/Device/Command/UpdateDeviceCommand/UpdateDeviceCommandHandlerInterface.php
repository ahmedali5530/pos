<?php 

namespace App\Core\Device\Command\UpdateDeviceCommand;

interface UpdateDeviceCommandHandlerInterface
{
    public function handle(UpdateDeviceCommand $command) : UpdateDeviceCommandResult;
}
