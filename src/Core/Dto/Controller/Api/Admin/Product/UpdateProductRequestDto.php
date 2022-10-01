<?php

namespace App\Core\Dto\Controller\Api\Admin\Product;

use App\Core\Dto\Common\Product\ProductPriceDto;
use App\Core\Dto\Common\Product\ProductVariantDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Core\Product\Command\UpdateProductCommand\UpdateProductCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductRequestDto
{
    /**
     * @var int|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $id;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $name;

    /**
     * @var string|null
     */
    private $sku;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
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
     * @Assert\NotBlank(normalizer="trim")
     */
    private $saleUnit;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $purchaseUnit;

    /**
     * @var ProductVariantDto[]|null
     */
    private $variants;

    /**
     * @var ProductPriceDto[]|null
     */
    private $prices;

    /**
     * @var int[]|null
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Category", entityName="Category")
     * )
     */
    private $categories;

    /**
     * @var int[]|null
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Supplier", entityName="Supplier")
     * )
     */
    private $suppliers;

    /**
     * @var int[]|null
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Brand", entityName="Brand")
     * )
     */
    private $brands;

    /**
     * @var float|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $cost;

    /**
     * @var int|null
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\Type(type="int")
     * @ConstraintValidEntity(class="App\Entity\Department", entityName="Department")
     */
    private $department;

    public static function createFromRequest(Request $request)
    {
        $dto = new self();

        $data = json_decode($request->getContent(), true);
        $dto->name = $data['name'] ?? null;
        $dto->sku = $data['sku'] ?? null;
        $dto->barcode = $data['barcode'] ?? null;
        $dto->baseQuantity = $data['baseQuantity'] ?? null;
        $dto->isAvailable = $data['isAvailable'] ?? null;
        $dto->basePrice = $data['basePrice'] ?? null;
        $dto->quantity = $data['quantity'] ?? null;
        $dto->purchaseUnit = $data['purchaseUnit'] ?? null;
        $dto->saleUnit = $data['saleUnit'] ?? null;

        foreach($data['variants'] ?? [] as $variant){
            $dto->variants[] = ProductVariantDto::createFromArray($variant);
        }

        foreach($data['prices'] ?? [] as $price){
            $dto->prices[] = ProductPriceDto::createFromArray($price);
        }

        $dto->cost = $data['cost'] ?? null;
        $dto->categories = $data['categories'] ?? null;
        $dto->brands = $data['brands'] ?? null;
        $dto->suppliers = $data['suppliers'] ?? null;
        $dto->id = $data['id'] ?? null;
        $dto->department = $data['department'] ?? null;

        return $dto;
    }

    public function populateCommand(UpdateProductCommand $command)
    {
        $command->setName($this->name);
        $command->setSku($this->sku);
        $command->setBarcode($this->barcode);
        $command->setBaseQuantity($this->baseQuantity);
        $command->setIsAvailable($this->isAvailable);
        $command->setBasePrice($this->basePrice);
        $command->setQuantity($this->quantity);
        $command->setPrices($this->prices);
        $command->setVariants($this->variants);
        $command->setCost($this->cost);
        $command->setPurchaseUnit($this->purchaseUnit);
        $command->setSaleUnit($this->saleUnit);
        $command->setCategories($this->categories);
        $command->setBrands($this->brands);
        $command->setSuppliers($this->suppliers);
        $command->setId($this->id);
        $command->setDepartment($this->department);
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
}
