<?php


namespace App\Core\Dto\Common\Tax;


use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\Tax;

class TaxDto
{
    use StoresDtoTrait;

    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Tax", class="App\Entity\Tax")
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

    public static function createFromTax(?Tax $tax): ?self
    {
        if($tax === null){
            return null;
        }

        $dto = new self();
        $dto->id = $tax->getId();
        $dto->name = $tax->getName();
        $dto->rate = $tax->getRate();

        $dto->setStores($tax->getStores());

        return $dto;
    }

    public static function createFromArray(?array $tax): ?self
    {
        if($tax === null){
            return null;
        }

        $dto = new self();
        $dto->id = $tax['id'] ?? null;
        $dto->name = $tax['name'] ?? null;
        $dto->rate = $tax['rate'] ?? null;

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
}
