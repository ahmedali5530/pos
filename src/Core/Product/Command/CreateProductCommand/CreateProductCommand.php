<?php

namespace App\Core\Product\Command\CreateProductCommand;

class CreateProductCommand
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $sku;

    /**
     * @var string|null
     */
    private $barcode;

    /**
     * @var float|null
     */
    private $baseQuantity;

    /**
     * @var bool|null
     */
    private $isAvailable;

    /**
     * @var float|null
     */
    private $basePrice;

    /**
     * @var float|null
     */
    private $quantity;

    /**
     * @var int[]|null
     */
    private $prices;

    /**
     * @var int[]|null
     */
    private $variants;

    /**
     * @var float|null
     */
    private $cost;

    /**
     * @var int[]|null
     */
    private $categories;

    /**
     * @var int[]|null
     */
    private $suppliers;

    /**
     * @var int[]|null
     */
    private $brands;

    /**
     * @var string|null
     */
    private $saleUnit;

    /**
     * @var string|null
     */
    private $purchaseUnit;

    public function getName()
    {
        return $this->name;
    }

    public function setName($field)
    {
        $this->name = $field;
        return $this;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($field)
    {
        $this->sku = $field;
        return $this;
    }

    public function getBarcode()
    {
        return $this->barcode;
    }

    public function setBarcode($field)
    {
        $this->barcode = $field;
        return $this;
    }

    public function getBaseQuantity()
    {
        return $this->baseQuantity;
    }

    public function setBaseQuantity($field)
    {
        $this->baseQuantity = $field;
        return $this;
    }

    public function getIsAvailable()
    {
        return $this->isAvailable;
    }

    public function setIsAvailable($field)
    {
        $this->isAvailable = $field;
        return $this;
    }

    public function getBasePrice()
    {
        return $this->basePrice;
    }

    public function setBasePrice($field)
    {
        $this->basePrice = $field;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($field)
    {
        $this->quantity = $field;
        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getPrices(): ?array
    {
        return $this->prices;
    }

    /**
     * @param int[]|null $prices
     */
    public function setPrices(?array $prices): void
    {
        $this->prices = $prices;
    }

    /**
     * @return int[]|null
     */
    public function getVariants(): ?array
    {
        return $this->variants;
    }

    /**
     * @param int[]|null $variants
     */
    public function setVariants(?array $variants): void
    {
        $this->variants = $variants;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @param int|null $category
     */
    public function setCategory(?int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return float|null
     */
    public function getCost(): ?float
    {
        return $this->cost;
    }

    /**
     * @param float|null $cost
     */
    public function setCost(?float $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return int[]|null
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @param int[]|null $categories
     */
    public function setCategories(?array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return int[]|null
     */
    public function getSuppliers(): ?array
    {
        return $this->suppliers;
    }

    /**
     * @param int[]|null $suppliers
     */
    public function setSuppliers(?array $suppliers): void
    {
        $this->suppliers = $suppliers;
    }

    /**
     * @return int[]|null
     */
    public function getBrands(): ?array
    {
        return $this->brands;
    }

    /**
     * @param int[]|null $brands
     */
    public function setBrands(?array $brands): void
    {
        $this->brands = $brands;
    }

    /**
     * @return string|null
     */
    public function getSaleUnit(): ?string
    {
        return $this->saleUnit;
    }

    /**
     * @param string|null $saleUnit
     */
    public function setSaleUnit(?string $saleUnit): void
    {
        $this->saleUnit = $saleUnit;
    }

    /**
     * @return string|null
     */
    public function getPurchaseUnit(): ?string
    {
        return $this->purchaseUnit;
    }

    /**
     * @param string|null $purchaseUnit
     */
    public function setPurchaseUnit(?string $purchaseUnit): void
    {
        $this->purchaseUnit = $purchaseUnit;
    }

}
