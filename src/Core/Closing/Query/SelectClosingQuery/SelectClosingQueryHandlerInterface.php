<?php

namespace App\Core\Closing\Query\SelectClosingQuery;

interface SelectClosingQueryHandlerInterface
{
    public function handle(SelectClosingQuery $command) : SelectClosingQueryResult;
}
