<?php


namespace App\Core\Cqrs\Traits;



use App\Core\Validation\ValidationResult;

interface CqrsResultWithValidationResultInterface
{
    public function getValidationResult(): ?ValidationResult;

    public function hasValidationError(): bool;
}