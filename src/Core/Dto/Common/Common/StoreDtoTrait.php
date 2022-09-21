<?php


namespace App\Core\Dto\Common\Common;


use App\Core\Dto\Common\Store\StoreDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\Store;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

trait StoreDtoTrait
{
    /**
     * @var int|null;
     * @Assert\NotBlank(normalizer="trim")
     * @ConstraintValidEntity(entityName="Store", class="App\Entity\Store")
     */
    private $store;

    /**
     * @return int|null
     */
    public function getStore(): ?int
    {
        return $this->store;
    }

    /**
     * @param int|null $store
     */
    public function setStore(?int $store): void
    {
        $this->store = $store;
    }
}
