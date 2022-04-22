<?php

namespace App\Core\Order\Command\RestoreOrderCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;
use App\Entity\Order;

class RestoreOrderCommandResult
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
    
    private Order $order;
    
    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }
    
    public function getOrder(): Order
    {
        return $this->order;
    }
}