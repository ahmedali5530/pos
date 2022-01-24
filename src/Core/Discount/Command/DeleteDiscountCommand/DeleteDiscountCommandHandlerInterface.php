<?php

namespace App\Core\Discount\Command\DeleteDiscountCommand;

interface DeleteDiscountCommandHandlerInterface
{
    public function handle(DeleteDiscountCommand $command): DeleteDiscountCommandResult;
}