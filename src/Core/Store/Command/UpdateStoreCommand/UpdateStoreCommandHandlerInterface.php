<?php

namespace App\Core\Store\Command\UpdateStoreCommand;

interface UpdateStoreCommandHandlerInterface
{
    public function handle(UpdateStoreCommand $command) : UpdateStoreCommandResult;
}
