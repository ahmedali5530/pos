<?php

namespace App\Core\Order\Command\RestoreOrderCommand;

interface RestoreOrderCommandHandlerInterface
{
    public function handle(RestoreOrderCommand $command): RestoreOrderCommandResult;
}