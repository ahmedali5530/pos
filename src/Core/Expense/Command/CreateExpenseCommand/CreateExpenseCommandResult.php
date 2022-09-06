<?php 

namespace App\Core\Expense\Command\CreateExpenseCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class CreateExpenseCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $expense = null;

    public function setExpense($expense)
    {
        $this->expense = $expense;
    }

    public function getExpense()
    {
        return $this->expense;
    }
}
