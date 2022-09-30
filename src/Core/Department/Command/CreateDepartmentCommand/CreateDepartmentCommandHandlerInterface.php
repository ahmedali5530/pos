<?php

namespace App\Core\Department\Command\CreateDepartmentCommand;

interface CreateDepartmentCommandHandlerInterface
{
    public function handle(CreateDepartmentCommand $command) : CreateDepartmentCommandResult;
}
