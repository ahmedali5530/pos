<?php

namespace App\Core\Dto\Controller\Api\Admin\Terminal;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Terminal\Query\SelectTerminalQuery\SelectTerminalQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectTerminalRequestDto
{
    use OrderTrait, LimitTrait, QTrait;

    const ORDERS_LIST = [
        'id' => 'Terminal.id',
        'code' => 'Terminal.code'
    ];


    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $code = null;

    /**
     * @var null|string
     */
    private $description = null;

    /**
     * @var null|bool
     */
    private $isActive = null;

    /**
     * @var null|\DateTimeImmutable
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

    public function setCode(?string $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
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

    public function setCreatedAt(?\DateTimeImmutable $createdAt)
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
        $dto->code = $request->query->get('code');
        $dto->description = $request->query->get('description');
        $dto->isActive = $request->query->get('isActive');

        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');
        $dto->q = $request->query->get('q');


        return $dto;
    }

    public function populateQuery(SelectTerminalQuery $query)
    {
        $query->setId($this->id);
        $query->setCode($this->code);
        $query->setDescription($this->description);
        $query->setIsActive($this->isActive);

        $query->setLimit($this->getLimit());
        $query->setOffset($this->getOffset());
        $query->setOrderBy($this->getOrderBy());
        $query->setOrderMode($this->getOrderMode());
        $query->setQ($this->q);
    }
}
