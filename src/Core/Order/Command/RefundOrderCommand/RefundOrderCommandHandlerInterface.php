<?php

namespace App\Core\Order\Command\RefundOrderCommand;

interface RefundOrderCommandHandlerInterface
{
    public function handle(RefundOrderCommand $command): RefundOrderCommandResult;
}