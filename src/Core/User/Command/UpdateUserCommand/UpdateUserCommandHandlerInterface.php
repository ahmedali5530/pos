<?php

namespace App\Core\User\Command\UpdateUserCommand;

interface UpdateUserCommandHandlerInterface
{
    public function handle(UpdateUserCommand $command) : UpdateUserCommandResult;
}
