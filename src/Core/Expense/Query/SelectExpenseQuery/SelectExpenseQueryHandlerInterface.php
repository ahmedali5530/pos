<?php 

namespace App\Core\Expense\Query\SelectExpenseQuery;

interface SelectExpenseQueryHandlerInterface
{
    public function handle(SelectExpenseQuery $command) : SelectExpenseQueryResult;
}
