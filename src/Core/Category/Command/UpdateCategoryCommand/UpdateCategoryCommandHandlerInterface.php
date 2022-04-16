<?php 

namespace App\Core\Category\Command\UpdateCategoryCommand;

interface UpdateCategoryCommandHandlerInterface
{
    public function handle(UpdateCategoryCommand $command) : UpdateCategoryCommandResult;
}
