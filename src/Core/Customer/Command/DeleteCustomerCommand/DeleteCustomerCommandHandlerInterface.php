<?php 

namespace App\Core\Customer\Command\DeleteCustomerCommand;

interface DeleteCustomerCommandHandlerInterface
{
    public function handle(DeleteCustomerCommand $command) : DeleteCustomerCommandResult;
}
