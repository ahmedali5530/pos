<?php 

namespace App\Core\Tax\Command\UpdateTaxCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class UpdateTaxCommandResult
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
