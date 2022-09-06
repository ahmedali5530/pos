<?php 

namespace App\Core\Supplier\Command\UpdateSupplierCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class UpdateSupplierCommandResult
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
