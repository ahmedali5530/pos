<?php

namespace App\Core\Discount\Query\GetDiscountListQuery;

interface GetDiscountListQueryHandlerInterface
{
    public function handle(GetDiscountListQuery $query): GetDiscountListQueryResult;
}