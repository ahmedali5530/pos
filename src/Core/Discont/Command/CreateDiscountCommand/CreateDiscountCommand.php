<?php

namespace App\Core\Discont\Command\CreateDiscountCommand;

use App\Core\Dto\Common\Common\StoresRequestDtoTrait;

class CreateDiscountCommand
{
    use StoresRequestDtoTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $rate;

    /**
     * @var string
     */
    private $rateType;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate(string $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getRateType(): string
    {
        return $this->rateType;
    }

    /**
     * @param string $rateType
     */
    public function setRateType(string $rateType): void
    {
        $this->rateType = $rateType;
    }
}
