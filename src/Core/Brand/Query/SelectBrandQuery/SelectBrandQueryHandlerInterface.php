<?php

namespace App\Core\Brand\Query\SelectBrandQuery;

interface SelectBrandQueryHandlerInterface
{
    public function handle(SelectBrandQuery $command) : SelectBrandQueryResult;
}
