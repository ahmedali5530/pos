<?php

namespace App\Core\Closing\Command\UpdateClosingCommand;

interface UpdateClosingCommandHandlerInterface
{
    public function handle(UpdateClosingCommand $command) : UpdateClosingCommandResult;
}
