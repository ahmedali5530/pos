<?php 

namespace App\Core\Customer\Query\SelectCustomerQuery;

interface SelectCustomerQueryHandlerInterface
{
    public function handle(SelectCustomerQuery $command) : SelectCustomerQueryResult;
}
