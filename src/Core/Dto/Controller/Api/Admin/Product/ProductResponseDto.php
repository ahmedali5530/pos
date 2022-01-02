<?php


namespace App\Core\Dto\Controller\Api\Admin\Product;


use App\Core\Dto\Common\Product\ProductDto;
use App\Entity\Product;

class ProductResponseDto
{
    /**
     * @var ProductDto|null
     */
    private $product;

    public static function createFromProduct(Product $product): self
    {
        $dto = new self();

        $dto->product = ProductDto::createFromProduct($product);

        return $dto;
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
}