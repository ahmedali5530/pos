<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Discount\DiscountDto;
use Symfony\Component\Validator\Constraints as Assert;

class CartProductDto
{
    /**
     * @var string|null
     */
    private $discount;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $price;

    /**
     * @var string|null
     * @Assert\NotBlank(normalizer="trim")
     */
    private $quantity;

    /**
     * @var ProductVariantDto|null
     * @Assert\Valid()
     */
    private $variant;

    /**
     * @var ProductDto
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $product;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->discount = $data['discount'] ?? null;
        $dto->price = $data['price'] ?? null;
        $dto->quantity = $data['quantity'] ?? null;
        $dto->variant = ProductVariantDto::createFromArray($data['variant'] ?? null);
        $dto->product = ProductDto::createFromArray($data['item'] ?? null);

        return $dto;
    }

    /**
     * @return string|null
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    /**
     * @param string|null $discount
     */
    public function setDiscount(?string $discount): void
    {
        $this->discount = $discount;
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
     * @return ProductDto
     */
    public function getProduct(): ProductDto
    {
        return $this->product;
    }

    /**
     * @param ProductDto $product
     */
    public function setProduct(ProductDto $product): void
    {
        $this->product = $product;
    }
}