<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Brand\BrandDto;
use App\Core\Dto\Common\Category\CategoryDto;
use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Core\Dto\Common\Department\DepartmentDto;
use App\Core\Dto\Common\Store\StoreShortDto;
use App\Core\Dto\Common\Supplier\SupplierDto;
use App\Core\Dto\Common\Tax\TaxDto;
use App\Core\Dto\Common\Terminal\TerminalShortDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\Product;

class ProductDto
{
    use ActiveDtoTrait;
    use TimestampsDtoTrait;
    use UuidDtoTrait;

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

    /**
     * @var TerminalShortDto[]
     */
    private $terminals = [];

    /**
     * @var ProductStoreDto[]
     */
    private $stores = [];

    /**
     * @var TaxDto[]
     */
    private $taxes = [];


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

        foreach($product->getCategories() as $category){
            $dto->categories[] = CategoryDto::createFromCategory($category);
        }

        foreach($product->getVariants() as $variant){
            $dto->variants[] = ProductVariantDto::createFromProductVariant($variant);
        }

        foreach($product->getPrices() as $productPrice){
            $dto->prices[] = ProductPriceDto::createFromProductPrice($productPrice);
        }

        foreach($product->getSuppliers() as $supplier){
            $dto->suppliers[] = SupplierDto::createFromSupplier($supplier);
        }

        foreach($product->getBrands() as $brand){
            $dto->brands[] = BrandDto::createFromBrand($brand);
        }

        foreach($product->getTerminals() as $terminal){
            $dto->terminals[] = TerminalShortDto::createFromTerminal($terminal);
        }

        foreach($product->getStores() as $store){
            $dto->stores[] = ProductStoreDto::createFromProductStore($store);
        }

        foreach($product->getTaxes() as $tax){
            $dto->taxes[] = TaxDto::createFromTax($tax);
        }

        $dto->uuid = $product->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($product->getCreatedAt());
        $dto->cost = $product->getCost();

        $dto->department = DepartmentDto::createFromDepartment($product->getDepartment());

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->sku = $data['sku'] ?? null;
        $dto->barcode = $data['barcode'] ?? null;
        $dto->baseQuantity = $data['baseQuantity'] ?? null;
        $dto->isActive = $data['isActive'] ?? null;
        $dto->isAvailable = $data['isAvailable'] ?? null;
        $dto->quantity = $data['quantity'] ?? null;
        $dto->basePrice = $data['basePrice'] ?? null;

        foreach($data['categories'] ?? [] as $category){
            $dto->categories[] = CategoryDto::createFromArray($category);
        }

        foreach($data['variants'] ?? [] as $variant){
            $dto->variants[] = ProductVariantDto::createFromArray($variant);
        }

        foreach($data['prices'] ?? [] as $productPrice){
            $dto->prices[] = ProductPriceDto::createFromArray($productPrice);
        }

        $dto->cost = $data['cost'] ?? null;

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

    /**
     * @return TerminalShortDto[]
     */
    public function getTerminals(): array
    {
        return $this->terminals;
    }

    /**
     * @param TerminalShortDto[] $terminals
     */
    public function setTerminals(array $terminals): void
    {
        $this->terminals = $terminals;
    }

    /**
     * @return ProductStoreDto[]
     */
    public function getStores(): array
    {
        return $this->stores;
    }

    /**
     * @param ProductStoreDto[] $stores
     */
    public function setStores(array $stores): void
    {
        $this->stores = $stores;
    }

    /**
     * @return TaxDto[]
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    /**
     * @param TaxDto[] $taxes
     */
    public function setTaxes(array $taxes): void
    {
        $this->taxes = $taxes;
    }
}
