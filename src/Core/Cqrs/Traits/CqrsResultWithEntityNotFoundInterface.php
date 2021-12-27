<?php


namespace App\Core\Cqrs\Traits;


interface CqrsResultWithEntityNotFoundInterface
{
    public function isNotFound(): bool;
}