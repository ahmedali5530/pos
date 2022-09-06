<?php 

namespace App\Core\Device\Command\CreateDeviceCommand;

interface CreateDeviceCommandHandlerInterface
{
    public function handle(CreateDeviceCommand $command) : CreateDeviceCommandResult;
}
