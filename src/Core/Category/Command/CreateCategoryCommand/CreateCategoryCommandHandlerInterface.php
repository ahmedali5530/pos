<?php 

namespace App\Core\Category\Command\CreateCategoryCommand;

interface CreateCategoryCommandHandlerInterface
{
    public function handle(CreateCategoryCommand $command) : CreateCategoryCommandResult;
}
