<?php

namespace App\Core\Product\Command\UpdateProductCommand;

use App\Core\Dto\Common\Product\ProductPriceDto;
use App\Core\Dto\Common\Product\ProductVariantDto;

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
     * @var string|null
     */
    private $baseQuantity;

    /**
     * @var bool|null
     */
    private $isAvailable;

    /**
     * @var string|null
     */
    private $basePrice;

    /**
     * @var string|null
     */
    private $quantity;

    /**
     * @var ProductPriceDto[]|null
     */
    private $prices;

    /**
     * @var ProductVariantDto[]|null
     */
    private $variants;

    /**
     * @var string|null
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

    /**
     * @var int|null
     */
    private $department;

    /**
     * @var int[]|null
     */
    private $taxes;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     */
    public function setBarcode(?string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @return string|null
     */
    public function getBaseQuantity(): ?string
    {
        return $this->baseQuantity;
    }

    /**
     * @param string|null $baseQuantity
     */
    public function setBaseQuantity(?string $baseQuantity): void
    {
        $this->baseQuantity = $baseQuantity;
    }

    /**
     * @return bool|null
     */
    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    /**
     * @param bool|null $isAvailable
     */
    public function setIsAvailable(?bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    /**
     * @return string|null
     */
    public function getBasePrice(): ?string
    {
        return $this->basePrice;
    }

    /**
     * @param string|null $basePrice
     */
    public function setBasePrice(?string $basePrice): void
    {
        $this->basePrice = $basePrice;
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
     * @return ProductPriceDto[]|null
     */
    public function getPrices(): ?array
    {
        return $this->prices;
    }

    /**
     * @param ProductPriceDto[]|null $prices
     */
    public function setPrices(?array $prices): void
    {
        $this->prices = $prices;
    }

    /**
     * @return ProductVariantDto[]|null
     */
    public function getVariants(): ?array
    {
        return $this->variants;
    }

    /**
     * @param ProductVariantDto[]|null $variants
     */
    public function setVariants(?array $variants): void
    {
        $this->variants = $variants;
    }

    /**
     * @return string|null
     */
    public function getCost(): ?string
    {
        return $this->cost;
    }

    /**
     * @param string|null $cost
     */
    public function setCost(?string $cost): void
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
     * @return int|null
     */
    public function getDepartment(): ?int
    {
        return $this->department;
    }

    /**
     * @param int|null $department
     */
    public function setDepartment(?int $department): void
    {
        $this->department = $department;
    }

    /**
     * @return int[]|null
     */
    public function getTaxes(): ?array
    {
        return $this->taxes;
    }

    /**
     * @param int[]|null $taxes
     */
    public function setTaxes(?array $taxes): void
    {
        $this->taxes = $taxes;
    }

}
