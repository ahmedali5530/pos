<?php

namespace App\Core\Dto\Controller\Api\Admin\Product;

use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Dto\Common\Common\StoresRequestDtoTrait;
use App\Core\Dto\Common\Product\ProductPriceDto;
use App\Core\Dto\Common\Product\ProductVariantDto;
use App\Core\Product\Command\CreateProductCommand\CreateProductCommand;
use App\Core\Validation\Custom\ConstraintValidEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProductRequestDto
{
    use StoresRequestDtoTrait;

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
     */
    private $barcode;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $baseQuantity;

    /**
     * @var bool|null
     */
    private $isAvailable;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $basePrice;

    /**
     * @var string|null
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
     * @var string|null
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

    /**
     * @var int[]|null
     * @Assert\All(
     *     @ConstraintValidEntity(class="App\Entity\Tax", entityName="Tax")
     * )
     */
    private $taxes;

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
        $dto->stores = $data['stores'] ?? null;
        $dto->department = $data['department'] ?? null;
        $dto->taxes = $data['taxes'] ?? null;

        return $dto;
    }

    public function populateCommand(CreateProductCommand $command)
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
        $command->setStores($this->getStores());
        $command->setDepartment($this->department);
        $command->setTaxes($this->taxes);
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

