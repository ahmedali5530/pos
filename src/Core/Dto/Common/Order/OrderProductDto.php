<?php


namespace App\Core\Dto\Common\Order;


use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Dto\Common\Product\ProductVariantDto;
use App\Entity\OrderProduct;

class OrderProductDto
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var ProductDto|null
     */
    private $product;

    /**
     * @var ProductVariantDto|null
     */
    private $variant;

    /**
     * @var float|null
     */
    private $quantity;

    /**
     * @var float|null
     */
    private $price;

    /**
     * @var boolean|null
     */
    private $isSuspended;

    /**
     * @var boolean|null
     */
    private $isDeleted;

    /**
     * @var boolean|null
     */
    private $isReturned;

    public static function createFromOrderProduct(?OrderProduct $orderProduct): ?self
    {
        if($orderProduct === null){
            return null;
        }

        $dto = new self();
        $dto->id = $orderProduct->getId();
        $dto->product = ProductDto::createFromProduct($orderProduct->getProduct());
        $dto->variant = ProductVariantDto::createFromProductVariant($orderProduct->getVariant());
        $dto->quantity = $orderProduct->getQuantity();
        $dto->price = $orderProduct->getPrice();
        $dto->isSuspended = $orderProduct->getIsSuspended();
        $dto->isDeleted = $orderProduct->getIsDeleted();
        $dto->isReturned = $orderProduct->getIsReturned();

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
     * @return ProductDto|null
     */
    public function getProduct(): ?ProductDto
    {
        return $this->product;
    }

    /**
     * @param ProductDto|null $product
     */
    public function setProduct(?ProductDto $product): void
    {
        $this->product = $product;
    }

    /**
     * @return ProductVariantDto|null
     */
    public function getVariant(): ?ProductVariantDto
    {
        return $this->variant;
    }

    /**
     * @param ProductVariantDto|null $variant
     */
    public function setVariant(?ProductVariantDto $variant): void
    {
        $this->variant = $variant;
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
     * @return bool|null
     */
    public function getIsSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    /**
     * @param bool|null $isSuspended
     */
    public function setIsSuspended(?bool $isSuspended): void
    {
        $this->isSuspended = $isSuspended;
    }

    /**
     * @return bool|null
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool|null $isDeleted
     */
    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return bool|null
     */
    public function getIsReturned(): ?bool
    {
        return $this->isReturned;
    }

    /**
     * @param bool|null $isReturned
     */
    public function setIsReturned(?bool $isReturned): void
    {
        $this->isReturned = $isReturned;
    }
}