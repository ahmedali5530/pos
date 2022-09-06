<?php

namespace App\Core\Supplier\Query\SelectSupplierQuery;

interface SelectSupplierQueryHandlerInterface
{
    public function handle(SelectSupplierQuery $command) : SelectSupplierQueryResult;
}
