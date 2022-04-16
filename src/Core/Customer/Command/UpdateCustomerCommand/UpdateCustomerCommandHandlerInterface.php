<?php 

namespace App\Core\Customer\Command\UpdateCustomerCommand;

interface UpdateCustomerCommandHandlerInterface
{
    public function handle(UpdateCustomerCommand $command) : UpdateCustomerCommandResult;
}
