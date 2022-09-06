<?php

namespace App\Core\Brand\Command\CreateBrandCommand;

interface CreateBrandCommandHandlerInterface
{
    public function handle(CreateBrandCommand $command) : CreateBrandCommandResult;
}
