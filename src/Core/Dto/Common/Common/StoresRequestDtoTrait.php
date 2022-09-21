<?php


namespace App\Core\Dto\Common\Common;


use App\Core\Validation\Custom\ConstraintValidEntity;
use Symfony\Component\Validator\Constraints as Assert;

trait StoresRequestDtoTrait
{
    /**
     * @var int[]|null
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Store", entityName="Store")
     * )
     */
    private $stores = [];

    /**
     * @return int[]|null
     */
    public function getStores(): ?array
    {
        return $this->stores;
    }

    /**
     * @param int[]|null $stores
     */
    public function setStores(?array $stores): void
    {
        $this->stores = $stores;
    }
}
