<?php

namespace App\Core\Dto\Common\Product;

use App\Core\Dto\Common\Store\StoreShortDto;
use App\Entity\ProductStore;

class ProductStoreDto
{
    /**
     * @var ProductDto|null
     */
    private $product;

    /**
     * @var StoreShortDto
     */
    private $store;

    /**
     * @var string|null
     */
    private $quantity;

    /**
     * @var string|null
     */
    private $location;

    /**
     * @var string|null
     */
    private $reOrderLevel;

    public static function createFromProductStore(ProductStore $productStore): self{
        $dto = new self();

        $dto->store = StoreShortDto::createFromStore($productStore->getStore());
        $dto->quantity = $productStore->getQuantity();
        $dto->location = $productStore->getLocation();
        $dto->reOrderLevel = $productStore->getReOrderLevel();

        return $dto;
    }

    /**
     * @return ProductDto|null
     */
    public function getProduct(): ?ProductDto
    {
        return $this->product;
    }

    /**
     * @param ProductDto|null $product
     */
    public function setProduct(?ProductDto $product): void
    {
        $this->product = $product;
    }

    /**
     * @return StoreShortDto
     */
    public function getStore(): StoreShortDto
    {
        return $this->store;
    }

    /**
     * @param StoreShortDto $store
     */
    public function setStore(StoreShortDto $store): void
    {
        $this->store = $store;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @param string|null $quantity
     */
    public function setQuantity(?string $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string|null
     */
    public function getReOrderLevel(): ?string
    {
        return $this->reOrderLevel;
    }

    /**
     * @param string|null $reOrderLevel
     */
    public function setReOrderLevel(?string $reOrderLevel): void
    {
        $this->reOrderLevel = $reOrderLevel;
    }
}
