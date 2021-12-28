<?php


namespace App\Core\Dto\Common\Order;


use App\Core\Dto\Common\Discount\DiscountDto;
use App\Core\Dto\Common\Tax\TaxDto;
use App\Entity\OrderTax;

class OrderTaxDto
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var float|null
     */
    private $rate;

    /**
     * @var float|null
     */
    private $amount;

    /**
     * @var TaxDto|null
     */
    private $type;

    public static function createFromOrderTax(?OrderTax $orderTax): ?self
    {
        if($orderTax === null){
            return null;
        }

        $dto = new self();
        $dto->id = $orderTax->getId();
        $dto->rate = $orderTax->getRate();
        $dto->amount = $orderTax->getAmount();
        $dto->type = TaxDto::createFromTax($orderTax->getType());

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
     * @return float|null
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * @param float|null $rate
     */
    public function setRate(?float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return TaxDto|null
     */
    public function getType(): ?TaxDto
    {
        return $this->type;
    }

    /**
     * @param TaxDto|null $type
     */
    public function setType(?TaxDto $type): void
    {
        $this->type = $type;
    }
}