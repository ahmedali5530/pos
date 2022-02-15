<?php 

namespace App\Core\Payment\Command\CreatePaymentCommand;

interface CreatePaymentCommandHandlerInterface
{
    public function handle(CreatePaymentCommand $command) : CreatePaymentCommandResult;
}
