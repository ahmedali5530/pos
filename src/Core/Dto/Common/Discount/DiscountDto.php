<?php


namespace App\Core\Dto\Common\Discount;


use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Entity\Discount;

class DiscountDto
{
    use StoresDtoTrait;

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

    /**
     * @var string|null
     */
    private $scope;

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
        $dto->scope = $discount->getScope();

        $dto->setStores($discount->getStores());

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'] ?? null;
        $dto->rate = $data['rate'] ?? null;
        $dto->rateType = $data['rateType'] ?? null;

        $dto->setStores($data['stores'] ?? []);

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

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @param string|null $scope
     */
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
    }
}
