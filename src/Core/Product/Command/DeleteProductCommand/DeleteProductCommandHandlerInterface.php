<?php

namespace App\Core\Product\Command\DeleteProductCommand;

interface DeleteProductCommandHandlerInterface
{
    public function handle(DeleteProductCommand $command): DeleteProductCommandResult;
}