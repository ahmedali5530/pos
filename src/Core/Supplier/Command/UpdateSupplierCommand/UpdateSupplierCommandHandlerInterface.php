<?php

namespace App\Core\Supplier\Command\UpdateSupplierCommand;

interface UpdateSupplierCommandHandlerInterface
{
    public function handle(UpdateSupplierCommand $command) : UpdateSupplierCommandResult;
}
