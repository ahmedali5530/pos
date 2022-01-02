<?php

namespace App\Core\Dto\Controller\Api\Admin\Product;

use App\Core\Product\Command\CreateProductCommand\CreateProductCommand;
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
    private $variants;

    /**
     * @var int[]|null
     */
    private $prices;

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
        $dto->uom = $data['uom'] ?? null;
        $dto->shortCode = $data['shortCode'] ?? null;
        $dto->variants = $data['variants'] ?? null;
        $dto->prices = $data['prices'] ?? null;

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
        $command->setUom($this->uom);
        $command->setShortCode($this->shortCode);
        $command->setPrices($this->prices);
        $command->setVariants($this->variants);
        $command->setId($this->id);
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

    /**
     * @return string|null
     */
    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    /**
     * @param string|null $shortCode
     */
    public function setShortCode(?string $shortCode): void
    {
        $this->shortCode = $shortCode;
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
}
