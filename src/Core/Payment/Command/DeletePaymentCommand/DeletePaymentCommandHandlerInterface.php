<?php 

namespace App\Core\Payment\Command\DeletePaymentCommand;

interface DeletePaymentCommandHandlerInterface
{
    public function handle(DeletePaymentCommand $command) : DeletePaymentCommandResult;
}
