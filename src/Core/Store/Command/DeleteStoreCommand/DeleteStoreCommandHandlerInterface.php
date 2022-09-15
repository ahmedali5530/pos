<?php

namespace App\Core\Store\Command\DeleteStoreCommand;

interface DeleteStoreCommandHandlerInterface
{
    public function handle(DeleteStoreCommand $command) : DeleteStoreCommandResult;
}
