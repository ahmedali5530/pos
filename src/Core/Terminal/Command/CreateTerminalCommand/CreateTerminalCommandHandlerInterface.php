<?php

namespace App\Core\Terminal\Command\CreateTerminalCommand;

interface CreateTerminalCommandHandlerInterface
{
    public function handle(CreateTerminalCommand $command) : CreateTerminalCommandResult;
}
