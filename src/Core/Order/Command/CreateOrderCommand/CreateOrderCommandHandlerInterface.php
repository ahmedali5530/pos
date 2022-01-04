<?php

namespace App\Core\Order\Command\CreateOrderCommand;

interface CreateOrderCommandHandlerInterface
{
    public function handle(CreateOrderCommand $command): CreateOrderCommandResult;
}