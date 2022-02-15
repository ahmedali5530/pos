<?php 

namespace App\Core\Tax\Query\SelectTaxQuery;

interface SelectTaxQueryHandlerInterface
{
    public function handle(SelectTaxQuery $command) : SelectTaxQueryResult;
}
