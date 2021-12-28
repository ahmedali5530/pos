<?php

namespace App\Core\Product\Command\CreateProductCommand;

use App\Core\Entity\EntityManager\EntityManager;

class CreateProductCommandHandler extends EntityManager implements CreateProductCommandHandlerInterface
{
    protected function getEntityClass(): string
    {
        //TODO: return Entity class
        return '';
    }
    
    public function handle(CreateProductCommand $command): CreateProductCommandResult
    {
        
    }
}