<?php

namespace App\Core\User\Command\CreateUserCommand;

interface CreateUserCommandHandlerInterface
{
    public function handle(CreateUserCommand $command) : CreateUserCommandResult;
}
