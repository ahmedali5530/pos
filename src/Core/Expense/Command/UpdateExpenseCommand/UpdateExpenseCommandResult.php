<?php 

namespace App\Core\Expense\Command\UpdateExpenseCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class UpdateExpenseCommandResult
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
