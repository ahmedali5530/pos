<?php 

namespace App\Core\Tax\Command\CreateTaxCommand;

interface CreateTaxCommandHandlerInterface
{
    public function handle(CreateTaxCommand $command) : CreateTaxCommandResult;
}
