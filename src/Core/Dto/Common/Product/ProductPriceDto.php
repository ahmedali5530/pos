<?php


namespace App\Core\Dto\Common\Product;


use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Entity\ProductPrice;

class ProductPriceDto
{
    use TimestampsDtoTrait;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var DateTimeDto|null
     */
    private $date;

    /**
     * @var DateTimeDto|null
     */
    private $time;

    /**
     * @var string|null
     */
    private $day;

    /**
     * @var float|null
     */
    private $rate;

    /**
     * @var float|null
     */
    private $minQuantity;

    /**
     * @var float|null
     */
    private $maxQuantity;

    /**
     * @var float|null
     */
    private $basePrice;

    /**
     * @var float|null
     */
    private $baseQuantity;

    public static function createFromProductPrice(?ProductPrice $productPrice): ?self
    {
        if($productPrice === null){
            return null;
        }

        $dto = new self();
        $dto->id = $productPrice->getId();
        $dto->date = DateTimeDto::createFromDateTime($productPrice->getDate());
        $dto->time = DateTimeDto::createFromDateTime($productPrice->getTime());
        $dto->day = $productPrice->getDay();
        $dto->rate = $productPrice->getRate();
        $dto->minQuantity = $productPrice->getMinQuantity();
        $dto->maxQuantity = $productPrice->getMaxQuantity();
        $dto->basePrice = $productPrice->getBasePrice();
        $dto->baseQuantity = $productPrice->getBaseQuantity();

        $dto->createdAt = DateTimeDto::createFromDateTime($productPrice->getCreatedAt());

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
     * @return DateTimeDto|null
     */
    public function getDate(): ?DateTimeDto
    {
        return $this->date;
    }

    /**
     * @param DateTimeDto|null $date
     */
    public function setDate(?DateTimeDto $date): void
    {
        $this->date = $date;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getTime(): ?DateTimeDto
    {
        return $this->time;
    }

    /**
     * @param DateTimeDto|null $time
     */
    public function setTime(?DateTimeDto $time): void
    {
        $this->time = $time;
    }

    /**
     * @return string|null
     */
    public function getDay(): ?string
    {
        return $this->day;
    }

    /**
     * @param string|null $day
     */
    public function setDay(?string $day): void
    {
        $this->day = $day;
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
    public function getMinQuantity(): ?float
    {
        return $this->minQuantity;
    }

    /**
     * @param float|null $minQuantity
     */
    public function setMinQuantity(?float $minQuantity): void
    {
        $this->minQuantity = $minQuantity;
    }

    /**
     * @return float|null
     */
    public function getMaxQuantity(): ?float
    {
        return $this->maxQuantity;
    }

    /**
     * @param float|null $maxQuantity
     */
    public function setMaxQuantity(?float $maxQuantity): void
    {
        $this->maxQuantity = $maxQuantity;
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
}