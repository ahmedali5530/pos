<?php

namespace App\Core\Tax\Query\SelectTaxQuery;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

class SelectTaxQuery
{
    use OrderTrait, QTrait, StoreDtoTrait, LimitTrait;

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|float
     */
    private $rate = null;

    /**
     * @var null|bool
     */
    private $isActive = null;


    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRate(?float $rate)
    {
        $this->rate = $rate;
        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }
}
