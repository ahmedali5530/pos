<?php

namespace App\Core\Order\Command\UpdateOrderCommand;

interface UpdateOrderCommandHandlerInterface
{
    public function handle(UpdateOrderCommand $command): UpdateOrderCommandResult;
}