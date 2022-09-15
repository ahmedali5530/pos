<?php

namespace App\Core\User\Command\DeleteUserCommand;

interface DeleteUserCommandHandlerInterface
{
    public function handle(DeleteUserCommand $command) : DeleteUserCommandResult;
}
