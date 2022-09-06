<?php 

namespace App\Core\Dto\Controller\Api\Admin\Expense;

use App\Core\Dto\Common\Expense\ExpenseDto;
use App\Entity\Expense;

class SelectExpenseResponseDto
{
    /**
     * @var ExpenseDto
     */
    private $expense = null;

    public static function createFromExpense(Expense $expense) : self
    {
        $dto = new self();

        $dto->expense = ExpenseDto::createFromExpense($expense);

        return $dto;
    }

    public function setExpense($expense)
    {
        $this->expense = $expense;
    }

    public function getExpense()
    {
        return $this->expense;
    }
}
