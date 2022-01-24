<?php

namespace App\Core\Discount\Command\UpdateDiscountCommand;

interface UpdateDiscountCommandHandlerInterface
{
    public function handle(UpdateDiscountCommand $command): UpdateDiscountCommandResult;
}