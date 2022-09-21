<?php

namespace App\Core\Dto\Controller\Api\Admin\Discount;

use App\Core\Discount\Query\GetDiscountListQuery\GetDiscountListQuery;
use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use Symfony\Component\HttpFoundation\Request;

class DiscountListRequestDto
{
    use OrderTrait, StoreDtoTrait, QTrait, LimitTrait;

    const ORDERS_LIST = [
        'name' => 'Discount.name',
        'rate' => 'Discount.rate',
        'rateType' => 'Discount.rateType',
        'scope' => 'Discount.scope'
    ];

    /**
     * @var string|null
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }

    public static function createFromRequest(Request $request)
    {
        $dto = new self();

        $dto->name = $request->query->get('name');
        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');
        $dto->q = $request->query->get('q');
        $dto->store = $request->query->get('store');

        return $dto;
    }

    public function populateQuery(GetDiscountListQuery $query)
    {
        $query->setName($this->name);
        $query->setLimit($this->limit);
        $query->setOffset($this->offset);
        $query->setOrderMode($this->orderMode);
        $query->setOrderBy($this->getOrderBy());
        $query->setQ($this->q);
        $query->setStore($this->getStore());
    }
}
