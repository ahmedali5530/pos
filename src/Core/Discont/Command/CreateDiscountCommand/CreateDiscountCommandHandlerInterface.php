<?php

namespace App\Core\Discont\Command\CreateDiscountCommand;

interface CreateDiscountCommandHandlerInterface
{
    public function handle(CreateDiscountCommand $command): CreateDiscountCommandResult;
}