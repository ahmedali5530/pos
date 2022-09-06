<?php

namespace App\Core\Brand\Command\UpdateBrandCommand;

interface UpdateBrandCommandHandlerInterface
{
    public function handle(UpdateBrandCommand $command) : UpdateBrandCommandResult;
}
