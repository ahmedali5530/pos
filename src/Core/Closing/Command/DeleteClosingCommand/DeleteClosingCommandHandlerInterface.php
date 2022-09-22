<?php

namespace App\Core\Closing\Command\DeleteClosingCommand;

interface DeleteClosingCommandHandlerInterface
{
    public function handle(DeleteClosingCommand $command) : DeleteClosingCommandResult;
}
