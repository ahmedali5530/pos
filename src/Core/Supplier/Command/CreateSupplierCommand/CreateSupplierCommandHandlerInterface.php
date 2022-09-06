<?php

namespace App\Core\Supplier\Command\CreateSupplierCommand;

interface CreateSupplierCommandHandlerInterface
{
    public function handle(CreateSupplierCommand $command) : CreateSupplierCommandResult;
}
