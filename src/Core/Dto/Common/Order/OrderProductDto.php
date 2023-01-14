<?php


namespace App\Core\Dto\Common\Order;


use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Dto\Common\Product\ProductVariantDto;
use App\Core\Dto\Common\Tax\TaxDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\OrderProduct;
use Symfony\Component\Validator\Constraints as Assert;

class OrderProductDto
{
    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Order product", class="App\Entity\OrderProduct")
     */
    private $id;

    /**
     * @var ProductDto|null
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $product;

    /**
     * @var ProductVariantDto|null
     * @Assert\Valid()
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
     * @var bool|null
     */
    private $isSuspended;

    /**
     * @var bool|null
     */
    private $isDeleted;

    /**
     * @var bool|null
     */
    private $isReturned;

    /**
     * @var TaxDto[]
     */
    private $taxes = [];

    /**
     * @var float|null
     */
    private $discount;

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

        foreach($orderProduct->getTaxes() as $tax){
            $dto->taxes[] = TaxDto::createFromTax($tax);
        }

        $dto->discount = $orderProduct->getDiscount();

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->product = ProductDto::createFromArray($data['product'] ?? null);
        $dto->variant = ProductVariantDto::createFromArray($data['variant'] ?? null);
        $dto->quantity = $data['quantity'] ?? null;
        $dto->price = $data['price'] ?? null;
        $dto->isSuspended = $data['isSuspended'] ?? null;
        $dto->isDeleted = $data['isDeleted'] ?? null;
        $dto->isReturned = $data['isReturned'] ?? null;

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

    public function getTaxesTotal(): float
    {
        $total = 0;
        foreach($this->taxes as $tax){
            $total += ($tax->getRate() * ($this->price * $this->quantity) / 100);
        }

        return $total;
    }

    /**
     * @return float|null
     */
    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    /**
     * @param float|null $discount
     */
    public function setDiscount(?float $discount): void
    {
        $this->discount = $discount;
    }
}
