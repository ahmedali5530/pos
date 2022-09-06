<?php 

namespace App\Core\Supplier\Command\CreateSupplierCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class CreateSupplierCommandResult
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
