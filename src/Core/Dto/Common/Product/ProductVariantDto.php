<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\ProductVariant;

class ProductVariantDto
{
    use TimestampsDtoTrait;

    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Product variant", class="App\Entity\ProductVariant")
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $attributeName;

    /**
     * @var string|null
     */
    private $attributeValue;

    /**
     * @var string|null
     */
    private $barcode;

    /**
     * @var string|null
     */
    private $sku;

    /**
     * @var string|null
     */
    private $price;

    /**
     * @var ProductPriceDto[]
     */
    private $prices = [];


    public static function createFromProductVariant(?ProductVariant $productVariant): ?self
    {
        if($productVariant === null){
            return null;
        }

        $dto = new self();
        $dto->id = $productVariant->getId();
        $dto->name = $productVariant->getName();
        $dto->attributeName = $productVariant->getAttributeName();
        $dto->attributeValue = $productVariant->getAttributeValue();
        $dto->barcode = $productVariant->getBarcode();
        $dto->sku = $productVariant->getSku();
        $dto->price = $productVariant->getPrice();
        foreach($productVariant->getPrices() as $price){
            $dto->prices[] = ProductPriceDto::createFromProductPrice($price);
        }

        $dto->createdAt = DateTimeDto::createFromDateTime($productVariant->getCreatedAt());

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
        $dto->attributeName = $data['attributeName'] ?? null;
        $dto->attributeValue = $data['attributeValue'] ?? null;
        $dto->barcode = $data['barcode'] ?? null;
        $dto->sku = $data['sku'] ?? null;
        $dto->price = $data['price'] ?? null;
//        foreach($data['prices'] ?? null as $price){
//            $dto->prices[] = ProductPriceDto::createFromArray($price);
//        }

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
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void
    {
        $this->price = $price;
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
    public function getAttributeName(): ?string
    {
        return $this->attributeName;
    }

    /**
     * @param string|null $attributeName
     */
    public function setAttributeName(?string $attributeName): void
    {
        $this->attributeName = $attributeName;
    }

    /**
     * @return string|null
     */
    public function getAttributeValue(): ?string
    {
        return $this->attributeValue;
    }

    /**
     * @param string|null $attributeValue
     */
    public function setAttributeValue(?string $attributeValue): void
    {
        $this->attributeValue = $attributeValue;
    }
}
