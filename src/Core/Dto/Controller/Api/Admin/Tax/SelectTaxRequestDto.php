<?php

namespace App\Core\Dto\Controller\Api\Admin\Tax;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Core\Tax\Query\SelectTaxQuery\SelectTaxQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectTaxRequestDto
{
    use LimitTrait, OrderTrait, QTrait, StoreDtoTrait;

    const ORDERS_LIST = [
        'id' => 'Tax.id',
        'name' => 'Tax.name',
        'rate' => 'Tax.rate'
    ];

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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->name = $request->query->get('name');
        $dto->rate = $request->query->get('rate');
        $dto->isActive = $request->query->get('isActive');

        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');
        $dto->q = $request->query->get('q');
        $dto->store = $request->query->get('store');


        return $dto;
    }

    public function populateQuery(SelectTaxQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setRate($this->rate);
        $query->setIsActive($this->isActive);

        $query->setLimit($this->limit);
        $query->setOffset($this->offset);
        $query->setOrderMode($this->orderMode);
        $query->setOrderBy($this->getOrderBy());
        $query->setQ($this->q);
        $query->setStore($this->getStore());
    }
}
