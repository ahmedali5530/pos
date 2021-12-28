<?php

namespace App\Core\Product\Command\CreateProductCommand;

interface CreateProductCommandHandlerInterface
{
    public function handle(CreateProductCommand $command): CreateProductCommandResult;
}