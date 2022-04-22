<?php

namespace App\Core\Order\Command\DispatchOrderCommand;

interface DispatchOrderCommandHandlerInterface
{
    public function handle(DispatchOrderCommand $command): DispatchOrderCommandResult;
}