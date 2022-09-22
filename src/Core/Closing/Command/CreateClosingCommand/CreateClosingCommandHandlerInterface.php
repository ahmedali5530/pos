<?php

namespace App\Core\Closing\Command\CreateClosingCommand;

interface CreateClosingCommandHandlerInterface
{
    public function handle(CreateClosingCommand $command) : CreateClosingCommandResult;
}
