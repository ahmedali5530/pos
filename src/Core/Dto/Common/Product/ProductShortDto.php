<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Brand\BrandDto;
use App\Core\Dto\Common\Category\CategoryDto;
use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Core\Dto\Common\Department\DepartmentDto;
use App\Core\Dto\Common\Supplier\SupplierDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\Product;

class ProductShortDto
{
    use ActiveDtoTrait;
    use TimestampsDtoTrait;
    use UuidDtoTrait;
    use StoresDtoTrait;


    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Product", class="App\Entity\Product")
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
    private $quantity;

    /**
     * @var float|null
     */
    private $basePrice;

    /**
     * @var CategoryDto[]
     */
    private $categories = [];

    /**
     * @var ProductVariantDto[]
     */
    private $variants = [];

    /**
     * @var ProductPriceDto[]
     */
    private $prices = [];

    /**
     * @var string|null
     */
    private $purchaseUnit;

    /**
     * @var string|null
     */
    private $saleUnit;

    /**
     * @var float|null
     */
    private $cost;

    /**
     * @var SupplierDto[]
     */
    private $suppliers = [];

    /**
     * @var BrandDto[]
     */
    private $brands = [];

    /**
     * @var DepartmentDto|null
     */
    private $department;


    public static function createFromProduct(?Product $product): ?self
    {
        if($product === null){
            return null;
        }

        $dto = new self();
        $dto->id = $product->getId();
        $dto->name = $product->getName();
        $dto->sku = $product->getSku();
        $dto->barcode = $product->getBarcode();
        $dto->baseQuantity = $product->getBaseQuantity();
        $dto->isActive = $product->getIsActive();
        $dto->isAvailable = $product->getIsAvailable();
        $dto->quantity = $product->getQuantity();
        $dto->basePrice = $product->getBasePrice();
        $dto->purchaseUnit = $product->getPurchaseUnit();
        $dto->saleUnit = $product->getSaleUnit();

        $dto->uuid = $product->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($product->getCreatedAt());
        $dto->cost = $product->getCost();

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
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
     * @return float|null
     */
    public function getBaseQuantity(): ?float
    {
        return $this->baseQuantity;
    }

    /**
     * @param float|null $baseQuantity
     */
    public function setBaseQuantity(?float $baseQuantity): void
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
     * @return float|null
     */
    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    /**
     * @param float|null $quantity
     */
    public function setQuantity(?float $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float|null
     */
    public function getBasePrice(): ?float
    {
        return $this->basePrice;
    }

    /**
     * @param float|null $basePrice
     */
    public function setBasePrice(?float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return ProductVariantDto[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    /**
     * @param ProductVariantDto[] $variants
     */
    public function setVariants(array $variants): void
    {
        $this->variants = $variants;
    }

    /**
     * @return ProductPriceDto[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * @param ProductPriceDto[] $prices
     */
    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
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
     * @return CategoryDto[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param CategoryDto[] $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
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

    /**
     * @return mixed
     */
    public function getSaleUnit()
    {
        return $this->saleUnit;
    }

    /**
     * @param mixed $saleUnit
     */
    public function setSaleUnit($saleUnit): void
    {
        $this->saleUnit = $saleUnit;
    }

    /**
     * @return SupplierDto[]
     */
    public function getSuppliers(): array
    {
        return $this->suppliers;
    }

    /**
     * @param SupplierDto[] $suppliers
     */
    public function setSuppliers(array $suppliers): void
    {
        $this->suppliers = $suppliers;
    }

    /**
     * @return BrandDto[]
     */
    public function getBrands(): array
    {
        return $this->brands;
    }

    /**
     * @param BrandDto[] $brands
     */
    public function setBrands(array $brands): void
    {
        $this->brands = $brands;
    }

    /**
     * @return DepartmentDto|null
     */
    public function getDepartment(): ?DepartmentDto
    {
        return $this->department;
    }

    /**
     * @param DepartmentDto|null $department
     */
    public function setDepartment(?DepartmentDto $department): void
    {
        $this->department = $department;
    }
}
