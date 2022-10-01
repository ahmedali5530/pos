<?php

namespace App\Core\Terminal\Query\SelectTerminalQuery;

interface SelectTerminalQueryHandlerInterface
{
    public function handle(SelectTerminalQuery $command) : SelectTerminalQueryResult;
}
