<?php 

namespace App\Core\Category\Command\DeleteCategoryCommand;

interface DeleteCategoryCommandHandlerInterface
{
    public function handle(DeleteCategoryCommand $command) : DeleteCategoryCommandResult;
}
