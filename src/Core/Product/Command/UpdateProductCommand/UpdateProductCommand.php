<?php

namespace App\Core\Product\Command\UpdateProductCommand;

class UpdateProductCommand
{
    /**
     * @var int
     */
    private $id;

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
     * @var string|null
     */
    private $uom;

    /**
     * @var string|null
     */
    private $shortCode;

    /**
     * @var int[]|null
     */
    private $prices;

    /**
     * @var int[]|null
     */
    private $variants;

    public function getId()
    {
        return $this->id;
    }

    public function setId($field)
    {
        $this->id = $field;
        return $this;
    }

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

    public function getUom()
    {
        return $this->uom;
    }

    public function setUom($field)
    {
        $this->uom = $field;
        return $this;
    }

    public function getShortCode()
    {
        return $this->shortCode;
    }

    public function setShortCode($field)
    {
        $this->shortCode = $field;
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
}