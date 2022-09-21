<?php

namespace App\Core\Dto\Controller\Api\Admin\Brand;

use App\Core\Brand\Query\SelectBrandQuery\SelectBrandQuery;
use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use Symfony\Component\HttpFoundation\Request;

class SelectBrandRequestDto
{
    use LimitTrait;
    use OrderTrait;
    use QTrait;
    use StoreDtoTrait;

    const ORDERS_LIST = [
        'id' => 'Brand.id',
        'name' => 'Brand.name',
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
        $dto->isActive = $request->query->get('isActive');

        $dto->q = $request->query->get('q');
        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');

        $dto->store = $request->query->get('store');


        return $dto;
    }

    public function populateQuery(SelectBrandQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setIsActive($this->isActive);
        $query->setLimit($this->getLimit());
        $query->setOffset($this->getOffset());
        $query->setOrderBy($this->getOrderBy());
        $query->setOrderMode($this->getOrderMode());
        $query->setQ($this->getQ());
        $query->setStore($this->getStore());
    }
}
