<?php

namespace App\Core\Department\Command\UpdateDepartmentCommand;

interface UpdateDepartmentCommandHandlerInterface
{
    public function handle(UpdateDepartmentCommand $command) : UpdateDepartmentCommandResult;
}
