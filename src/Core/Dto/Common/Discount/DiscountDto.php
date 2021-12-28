<?php


namespace App\Core\Dto\Common\Discount;


use App\Entity\Discount;

class DiscountDto
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var float|null
     */
    private $rate;

    /**
     * @var string|null
     */
    private $rateType;

    public static function createFromDiscount(?Discount $discount): ?self
    {
        if($discount === null){
            return null;
        }

        $dto = new self();
        $dto->id = $discount->getId();
        $dto->name = $discount->getName();
        $dto->rate = $discount->getRate();
        $dto->rateType = $discount->getRateType();

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
     * @return string|null
     */
    public function getRateType(): ?string
    {
        return $this->rateType;
    }

    /**
     * @param string|null $rateType
     */
    public function setRateType(?string $rateType): void
    {
        $this->rateType = $rateType;
    }
}