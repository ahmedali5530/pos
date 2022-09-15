<?php 

namespace App\Core\Store\Command\UpdateStoreCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class UpdateStoreCommandResult
{
    use CqrsResultEntityNotFoundTrait, CqrsResultValidationTrait;

    public $store = null;

    public function setStore($store)
    {
        $this->store = $store;
    }

    public function getStore()
    {
        return $this->store;
    }
}
