<?php 

namespace App\Core\Tax\Command\UpdateTaxCommand;

interface UpdateTaxCommandHandlerInterface
{
    public function handle(UpdateTaxCommand $command) : UpdateTaxCommandResult;
}
