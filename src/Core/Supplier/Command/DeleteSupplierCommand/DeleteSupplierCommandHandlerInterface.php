<?php

namespace App\Core\Supplier\Command\DeleteSupplierCommand;

interface DeleteSupplierCommandHandlerInterface
{
    public function handle(DeleteSupplierCommand $command) : DeleteSupplierCommandResult;
}
