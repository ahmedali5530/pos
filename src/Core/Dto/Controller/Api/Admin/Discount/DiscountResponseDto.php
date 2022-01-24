<?php


namespace App\Core\Dto\Controller\Api\Admin\Discount;


use App\Core\Dto\Common\Discount\DiscountDto;
use App\Entity\Discount;

class DiscountResponseDto
{
    /**
     * @var DiscountDto|null
     */
    private $discount;

    public static function createFromDiscount(?Discount $discount)
    {
        $dto = new self();

        $dto->discount = DiscountDto::createFromDiscount($discount);
        return $dto;
    }

    /**
     * @return DiscountDto|null
     */
    public function getDiscount(): ?DiscountDto
    {
        return $this->discount;
    }

    /**
     * @param DiscountDto|null $discount
     */
    public function setDiscount(?DiscountDto $discount): void
    {
        $this->discount = $discount;
    }
}