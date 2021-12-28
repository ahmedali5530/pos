<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Entity\ProductVariant;

class ProductVariantDto
{
    use TimestampsDtoTrait;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $size;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @var string|null
     */
    private $weight;

    /**
     * @var string|null
     */
    private $barcode;

    /**
     * @var string|null
     */
    private $sku;

    /**
     * @var float|null
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
        $dto->size = $productVariant->getSize();
        $dto->color = $productVariant->getColor();
        $dto->weight = $productVariant->getWeight();
        $dto->barcode = $productVariant->getBarcode();
        $dto->sku = $productVariant->getSku();
        $dto->price = $productVariant->getPrice();
        foreach($productVariant->getPrices() as $price){
            $dto->prices[] = ProductPriceDto::createFromProductPrice($price);
        }

        $dto->createdAt = DateTimeDto::createFromDateTime($productVariant->getCreatedAt());

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
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @param string|null $size
     */
    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     */
    public function setWeight(?string $weight): void
    {
        $this->weight = $weight;
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
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
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
}