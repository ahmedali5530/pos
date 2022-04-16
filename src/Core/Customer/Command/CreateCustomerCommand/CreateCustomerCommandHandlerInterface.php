<?php 

namespace App\Core\Customer\Command\CreateCustomerCommand;

interface CreateCustomerCommandHandlerInterface
{
    public function handle(CreateCustomerCommand $command) : CreateCustomerCommandResult;
}
