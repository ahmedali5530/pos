<?php


namespace App\Core\Dto\Common\Common;


use App\Core\Dto\Common\Store\StoreDto;
use App\Entity\Store;
use Doctrine\Common\Collections\Collection;

trait StoresDtoTrait
{
    /**
     * @var StoreDto[]|null;
     */
    private $stores = [];

    /**
     * @return StoreDto[]|null
     */
    public function getStores(): ?array
    {
        return $this->stores;
    }

    /**
     * @param Collection|Store[]|StoreDto[]|null $stores
     */
    public function setStores(iterable $stores): void
    {
        foreach($stores as $store){
            if($store instanceof Store){
                $this->stores[] = StoreDto::createFromStore($store);
            }

            if($store instanceof StoreDto){
                $this->stores[] = $store;
            }

            if(is_array($store)){
                $this->stores[] = StoreDto::createFromArray($stores);
            }
        }
    }
}
