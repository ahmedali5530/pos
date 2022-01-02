<?php

namespace App\Core\Product\Command\UpdateProductCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;
use App\Entity\Product;

class UpdateProductCommandResult
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
    
    private product $product;
    
    public function setProduct(product $product): self
    {
        $this->product = $product;
        return $this;
    }
    
    public function getProduct(): product
    {
        return $this->product;
    }
}