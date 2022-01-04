<?php

namespace App\Core\Order\Command\DeleteOrderCommand;

interface DeleteOrderCommandHandlerInterface
{
    public function handle(DeleteOrderCommand $command): DeleteOrderCommandResult;
}