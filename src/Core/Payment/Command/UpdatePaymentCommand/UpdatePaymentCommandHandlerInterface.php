<?php 

namespace App\Core\Payment\Command\UpdatePaymentCommand;

interface UpdatePaymentCommandHandlerInterface
{
    public function handle(UpdatePaymentCommand $command) : UpdatePaymentCommandResult;
}
