<?php 

namespace App\Core\Payment\Query\SelectPaymentQuery;

interface SelectPaymentQueryHandlerInterface
{
    public function handle(SelectPaymentQuery $command) : SelectPaymentQueryResult;
}
