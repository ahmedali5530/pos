<?php

namespace App\Core\Terminal\Command\DeleteTerminalCommand;

interface DeleteTerminalCommandHandlerInterface
{
    public function handle(DeleteTerminalCommand $command) : DeleteTerminalCommandResult;
}
