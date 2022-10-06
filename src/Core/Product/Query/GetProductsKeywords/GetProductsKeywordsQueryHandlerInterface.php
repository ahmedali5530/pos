<?php

namespace App\Core\Product\Query\GetProductsKeywords;

interface GetProductsKeywordsQueryHandlerInterface
{
    public function handle(GetProductsKeywordsQuery $query): GetProductsKeywordsQueryResult;
}
