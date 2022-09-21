<?php

namespace App\Core\Payment\Query\SelectPaymentQuery;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;

class SelectPaymentQuery
{
    use StoreDtoTrait, LimitTrait, QTrait, OrderTrait;

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $type = null;

    /**
     * @var null|bool
     */
    private $canHaveChangeDue = null;

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

    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setCanHaveChangeDue(?bool $canHaveChangeDue)
    {
        $this->canHaveChangeDue = $canHaveChangeDue;
        return $this;
    }

    public function getCanHaveChangeDue()
    {
        return $this->canHaveChangeDue;
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
