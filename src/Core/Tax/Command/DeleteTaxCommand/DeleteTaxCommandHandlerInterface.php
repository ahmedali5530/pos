<?php 

namespace App\Core\Tax\Command\DeleteTaxCommand;

interface DeleteTaxCommandHandlerInterface
{
    public function handle(DeleteTaxCommand $command) : DeleteTaxCommandResult;
}
