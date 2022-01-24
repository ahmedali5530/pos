<?php

namespace App\Core\Discount\Command\UpdateDiscountCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;
use App\Entity\Discount;

class UpdateDiscountCommandResult
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