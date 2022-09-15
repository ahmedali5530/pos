<?php

namespace App\Core\Dto\Controller\Api\Admin\Store;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Store\Query\SelectStoreQuery\SelectStoreQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectStoreRequestDto
{
    use LimitTrait, OrderTrait, QTrait;
    const ORDERS_LIST = [
        'name' => 'Store.name',
        'location' => 'Store.location'
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
     * @var null|string
     */
    private $location = null;

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

    public function setLocation(?string $location)
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }


    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->name = $request->query->get('name');
        $dto->location = $request->query->get('location');

        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');
        $dto->q = $request->query->get('q');


        return $dto;
    }

    public function populateQuery(SelectStoreQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setLocation($this->location);

        $query->setLimit($this->getLimit());
        $query->setOffset($this->getOffset());
        $query->setOrderBy($this->getOrderBy());
        $query->setOrderMode($this->getOrderMode());
        $query->setQ($this->q);
    }
}
