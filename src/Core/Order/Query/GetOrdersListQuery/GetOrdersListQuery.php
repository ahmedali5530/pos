<?php

namespace App\Core\Order\Query\GetOrdersListQuery;

use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Controller\Api\Admin\Order\OrderRequestListDto;

class GetOrdersListQuery extends OrderRequestListDto
{
    /**
     * @var string|null
     */
    private $orderBy;

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param string|null $orderBy
     */
    public function setOrderBy(?string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }
}