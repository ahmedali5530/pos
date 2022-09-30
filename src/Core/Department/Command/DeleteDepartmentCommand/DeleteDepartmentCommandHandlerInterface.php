<?php

namespace App\Core\Department\Command\DeleteDepartmentCommand;

interface DeleteDepartmentCommandHandlerInterface
{
    public function handle(DeleteDepartmentCommand $command) : DeleteDepartmentCommandResult;
}
