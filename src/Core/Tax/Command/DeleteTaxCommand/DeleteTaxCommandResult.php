<?php 

namespace App\Core\Tax\Command\DeleteTaxCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class DeleteTaxCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $tax = null;

    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    public function getTax()
    {
        return $this->tax;
    }
}
