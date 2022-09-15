<?php

namespace App\Core\User\Query\SelectUserQuery;

interface SelectUserQueryHandlerInterface
{
    public function handle(SelectUserQuery $command) : SelectUserQueryResult;
}
