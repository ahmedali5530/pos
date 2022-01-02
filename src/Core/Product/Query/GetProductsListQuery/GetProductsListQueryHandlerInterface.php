<?php

namespace App\Core\Product\Query\GetProductsListQuery;

interface GetProductsListQueryHandlerInterface
{
    public function handle(GetProductsListQuery $query): GetProductsListQueryResult;
}