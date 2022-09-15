<?php

namespace App\Core\Dto\Controller\Api\Admin\Store;

use App\Core\Dto\Common\Store\StoreDto;
use App\Entity\Store;

class SelectStoreResponseDto
{
    /**
     * @var StoreDto
     */
    private $store = null;

    public static function createFromStore(Store $store) : self
    {
        $dto = new self();

        $dto->store = StoreDto::createFromStore($store);

        return $dto;
    }

    public function setStore($store)
    {
        $this->store = $store;
    }

    public function getStore()
    {
        return $this->store;
    }
}
