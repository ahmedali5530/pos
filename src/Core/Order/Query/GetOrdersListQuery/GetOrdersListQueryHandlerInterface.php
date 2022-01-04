<?php

namespace App\Core\Order\Query\GetOrdersListQuery;

interface GetOrdersListQueryHandlerInterface
{
    public function handle(GetOrdersListQuery $query): GetOrdersListQueryResult;
}