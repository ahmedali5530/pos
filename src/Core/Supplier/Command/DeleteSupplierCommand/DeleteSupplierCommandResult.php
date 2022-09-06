<?php 

namespace App\Core\Supplier\Command\DeleteSupplierCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class DeleteSupplierCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $supplier = null;

    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    public function getSupplier()
    {
        return $this->supplier;
    }
}
