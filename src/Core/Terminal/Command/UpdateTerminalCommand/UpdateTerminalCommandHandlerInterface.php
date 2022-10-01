<?php

namespace App\Core\Terminal\Command\UpdateTerminalCommand;

interface UpdateTerminalCommandHandlerInterface
{
    public function handle(UpdateTerminalCommand $command) : UpdateTerminalCommandResult;
}
