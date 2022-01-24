<?php

namespace App\Core\Discont\Command\CreateDiscountCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;
use App\Entity\Discount;

class CreateDiscountCommandResult
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
    
    private Discount $discount;
    
    public function setDiscount(Discount $discount): self
    {
        $this->discount = $discount;
        return $this;
    }
    
    public function getDiscount(): Discount
    {
        return $this->discount;
    }
}