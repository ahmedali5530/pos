<?php

namespace App\Core\Dto\Controller\Api\Admin\Category;

use App\Core\Category\Query\SelectCategoryQuery\SelectCategoryQuery;
use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use Symfony\Component\HttpFoundation\Request;

class SelectCategoryRequestDto
{
    use LimitTrait;
    use OrderTrait;
    use QTrait;
    use StoreDtoTrait;

    const ORDERS_LIST = [
        'id' => 'Category.id',
        'name' => 'Category.name',
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
    private $type = null;

    /**
     * @var null|bool
     */
    private $isActive = null;

    /**
     * @var null|\DateTimeInterface
     */
    private $createdAt = null;

    /**
     * @var null|string
     */
    private $uuid = null;

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

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUuid(?string $uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->name = $request->query->get('name');
        $dto->type = $request->query->get('type');
        $dto->isActive = $request->query->get('isActive');
        $dto->createdAt = $request->query->get('createdAt');
        $dto->uuid = $request->query->get('uuid');

        $dto->q = $request->query->get('q');
        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');

        $dto->store = $request->query->get('store');


        return $dto;
    }

    public function populateQuery(SelectCategoryQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setType($this->type);
        $query->setIsActive($this->isActive);
        $query->setCreatedAt($this->createdAt);
        $query->setUuid($this->uuid);
        $query->setLimit($this->getLimit());
        $query->setOffset($this->getOffset());
        $query->setOrderBy($this->getOrderBy());
        $query->setOrderMode($this->getOrderMode());
        $query->setQ($this->getQ());
        $query->setStore($this->store);
    }
}
