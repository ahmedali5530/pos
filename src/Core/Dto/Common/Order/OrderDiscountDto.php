<?php


namespace App\Core\Dto\Common\Order;


use App\Core\Dto\Common\Discount\DiscountDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\OrderDiscount;

class OrderDiscountDto
{
    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Order discount", class="App\Entity\OrderDiscount")
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
     * @var DiscountDto|null
     */
    private $type;


    public static function createFromOrderDiscount(?OrderDiscount $orderDiscount): ?self
    {
        if($orderDiscount === null){
            return null;
        }

        $dto = new self();
        $dto->id = $orderDiscount->getId();
        $dto->rate = $orderDiscount->getRate();
        $dto->amount = $orderDiscount->getAmount();
        $dto->type = DiscountDto::createFromDiscount($orderDiscount->getType());

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->rate = $data['rate'] ?? null;
        $dto->amount = $data['amount'] ?? null;
        $dto->type = DiscountDto::createFromArray($data['type']);

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
     * @return DiscountDto|null
     */
    public function getType(): ?DiscountDto
    {
        return $this->type;
    }

    /**
     * @param DiscountDto|null $type
     */
    public function setType(?DiscountDto $type): void
    {
        $this->type = $type;
    }
}