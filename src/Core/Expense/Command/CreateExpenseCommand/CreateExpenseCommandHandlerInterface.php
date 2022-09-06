<?php 

namespace App\Core\Expense\Command\CreateExpenseCommand;

interface CreateExpenseCommandHandlerInterface
{
    public function handle(CreateExpenseCommand $command) : CreateExpenseCommandResult;
}
