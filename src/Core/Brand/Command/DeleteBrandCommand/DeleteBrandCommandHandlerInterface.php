<?php

namespace App\Core\Brand\Command\DeleteBrandCommand;

interface DeleteBrandCommandHandlerInterface
{
    public function handle(DeleteBrandCommand $command) : DeleteBrandCommandResult;
}
