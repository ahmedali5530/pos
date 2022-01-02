<?php

namespace App\Core\Product\Command\DeleteProductCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;
use App\Entity\Product;

class DeleteProductCommandResult
{
    use CqrsResultEntityNotFoundTrait;
    use CqrsResultValidationTrait;
}