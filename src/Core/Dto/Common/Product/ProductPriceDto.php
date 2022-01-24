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
     * @var int|null
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

    /**
     * @var int|null
     */
    private $week;

    /**
     * @var int|null
     */
    private $month;

    /**
     * @var int|null
     */
    private $quarter;

    /**
     * @var DateTimeDto|null
     */
    private $timeTo;

    public static function createFromProductPrice(?ProductPrice $productPrice): ?self
    {
        if($productPrice === null){
            return null;
        }

        $dto = new self();
        $dto->id = $productPrice->getId();
        $dto->date = $productPrice->getDate();
        $dto->time = DateTimeDto::createFromDateTime($productPrice->getTime());
        $dto->timeTo = DateTimeDto::createFromDateTime($productPrice->getTimeTo());
        $dto->day = $productPrice->getDay();
        $dto->rate = $productPrice->getRate();
        $dto->minQuantity = $productPrice->getMinQuantity();
        $dto->maxQuantity = $productPrice->getMaxQuantity();
        $dto->basePrice = $productPrice->getBasePrice();
        $dto->baseQuantity = $productPrice->getBaseQuantity();
        $dto->week = $productPrice->getWeek();
        $dto->month = $productPrice->getMonth();
        $dto->quarter = $productPrice->getQuarter();

        $dto->createdAt = DateTimeDto::createFromDateTime($productPrice->getCreatedAt());

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->date = $data['date'] ?? null;
        $dto->time = DateTimeDto::createFromDateTime($data['time']['datetime'] ?? null);
        $dto->timeTo = DateTimeDto::createFromDateTime($data['timeTo']['datetime'] ?? null);
        $dto->day = $data['day'] ?? null;
        $dto->rate = $data['rate'] ?? null;
        $dto->minQuantity = $data['minQuantity'] ?? null;
        $dto->maxQuantity = $data['maxQuantity'] ?? null;
        $dto->basePrice = $data['basePrice'] ?? null;
        $dto->baseQuantity = $data['baseQuantity'] ?? null;
        $dto->week = $data['week'] ?? null;
        $dto->month = $data['month'] ?? null;
        $dto->quarter = $data['quarter'] ?? null;

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
     * @return int|null
     */
    public function getDate(): ?int
    {
        return $this->date;
    }

    /**
     * @param int|null $date
     */
    public function setDate(?int $date): void
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

    /**
     * @return int|null
     */
    public function getWeek(): ?int
    {
        return $this->week;
    }

    /**
     * @param int|null $week
     */
    public function setWeek(?int $week): void
    {
        $this->week = $week;
    }

    /**
     * @return int|null
     */
    public function getMonth(): ?int
    {
        return $this->month;
    }

    /**
     * @param int|null $month
     */
    public function setMonth(?int $month): void
    {
        $this->month = $month;
    }

    /**
     * @return int|null
     */
    public function getQuarter(): ?int
    {
        return $this->quarter;
    }

    /**
     * @param int|null $quarter
     */
    public function setQuarter(?int $quarter): void
    {
        $this->quarter = $quarter;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getTimeTo(): ?DateTimeDto
    {
        return $this->timeTo;
    }

    /**
     * @param DateTimeDto|null $timeTo
     */
    public function setTimeTo(?DateTimeDto $timeTo): void
    {
        $this->timeTo = $timeTo;
    }
}