<?php 

namespace App\Core\Expense\Command\UpdateExpenseCommand;

interface UpdateExpenseCommandHandlerInterface
{
    public function handle(UpdateExpenseCommand $command) : UpdateExpenseCommandResult;
}
