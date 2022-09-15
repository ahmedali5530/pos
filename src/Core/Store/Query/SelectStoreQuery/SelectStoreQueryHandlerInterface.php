<?php

namespace App\Core\Store\Query\SelectStoreQuery;

interface SelectStoreQueryHandlerInterface
{
    public function handle(SelectStoreQuery $command) : SelectStoreQueryResult;
}
