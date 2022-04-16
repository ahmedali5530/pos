<?php 

namespace App\Core\Category\Query\SelectCategoryQuery;

interface SelectCategoryQueryHandlerInterface
{
    public function handle(SelectCategoryQuery $command) : SelectCategoryQueryResult;
}
