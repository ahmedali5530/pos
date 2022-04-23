<?php 

namespace App\Core\Customer\Command\CreatePaymentCommand;

interface CreatePaymentCommandHandlerInterface
{
    public function handle(CreatePaymentCommand $command) : CreatePaymentCommandResult;
}
