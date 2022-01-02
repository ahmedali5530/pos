<?php

namespace App\Core\Product\Command\UpdateProductCommand;

interface UpdateProductCommandHandlerInterface
{
    public function handle(UpdateProductCommand $command): UpdateProductCommandResult;
}