<?php


namespace App\Core\Cqrs\Traits;


interface CqrsResultWithExceptionInterface
{
    public function getException(): \Exception;

    public function hasException(): bool;
}