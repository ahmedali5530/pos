<?php

namespace App\Core\Store\Command\CreateStoreCommand;

interface CreateStoreCommandHandlerInterface
{
    public function handle(CreateStoreCommand $command) : CreateStoreCommandResult;
}
