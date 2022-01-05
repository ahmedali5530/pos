<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Category\CategoryDto;
use App\Core\Dto\Common\Common\ActiveDtoTrait;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
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
     * @var CategoryDto|null
     */
    private $category;

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
    private $uom;


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
        $dto->uom = $product->getUom();

        $dto->category = CategoryDto::createFromCategory($product->getCategory());

        foreach($product->getVariants() as $variant){
            $dto->variants[] = ProductVariantDto::createFromProductVariant($variant);
        }
        foreach($product->getPrices() as $productPrice){
            $dto->prices[] = ProductPriceDto::createFromProductPrice($productPrice);
        }

        $dto->uuid = $product->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($product->getCreatedAt());

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
        $dto->category = CategoryDto::createFromArray($data['category'] ?? null);

        foreach($data['variants'] ?? [] as $variant){
            $dto->variants[] = ProductVariantDto::createFromArray($variant);
        }
        foreach($data['prices'] ?? [] as $productPrice){
            $dto->prices[] = ProductPriceDto::createFromArray($productPrice);
        }

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
     * @return CategoryDto|null
     */
    public function getCategory(): ?CategoryDto
    {
        return $this->category;
    }

    /**
     * @param CategoryDto|null $category
     */
    public function setCategory(?CategoryDto $category): void
    {
        $this->category = $category;
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
     * @return string|null
     */
    public function getUom(): ?string
    {
        return $this->uom;
    }

    /**
     * @param string|null $uom
     */
    public function setUom(?string $uom): void
    {
        $this->uom = $uom;
    }
}