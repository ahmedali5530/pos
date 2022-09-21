<?php

namespace App\Core\Dto\Controller\Api\Admin\Payment;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Core\Payment\Query\SelectPaymentQuery\SelectPaymentQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectPaymentRequestDto
{
    use StoreDtoTrait, QTrait, OrderTrait, LimitTrait;

    const ORDERS_LIST = [
        'id' => 'Payment.id',
        'name' => 'Payment.name',
        'type' => 'Payment.type'
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->name = $request->query->get('name');
        $dto->type = $request->query->get('type');
        $dto->canHaveChangeDue = $request->query->get('canHaveChangeDue');
        $dto->isActive = $request->query->get('isActive');

        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');
        $dto->q = $request->query->get('q');
        $dto->store = $request->query->get('store');


        return $dto;
    }

    public function populateQuery(SelectPaymentQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setType($this->type);
        $query->setCanHaveChangeDue($this->canHaveChangeDue);
        $query->setIsActive($this->isActive);

        $query->setLimit($this->limit);
        $query->setOffset($this->offset);
        $query->setOrderMode($this->orderMode);
        $query->setOrderBy($this->getOrderBy());
        $query->setQ($this->q);
        $query->setStore($this->getStore());
    }
}
