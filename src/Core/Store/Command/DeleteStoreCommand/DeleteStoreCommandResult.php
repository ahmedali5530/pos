<?php 

namespace App\Core\Store\Command\DeleteStoreCommand;

use App\Core\Cqrs\Traits\CqrsResultEntityNotFoundTrait;
use App\Core\Cqrs\Traits\CqrsResultValidationTrait;

class DeleteStoreCommandResult
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
