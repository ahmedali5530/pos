<?php

namespace App\Core\Department\Query\SelectDepartmentQuery;

interface SelectDepartmentQueryHandlerInterface
{
    public function handle(SelectDepartmentQuery $command) : SelectDepartmentQueryResult;
}
