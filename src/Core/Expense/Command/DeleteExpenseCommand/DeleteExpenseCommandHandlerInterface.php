<?php 

namespace App\Core\Expense\Command\DeleteExpenseCommand;

interface DeleteExpenseCommandHandlerInterface
{
    public function handle(DeleteExpenseCommand $command) : DeleteExpenseCommandResult;
}
