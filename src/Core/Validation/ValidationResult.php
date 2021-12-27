<?php


namespace App\Core\Validation;


class ValidationResult
{
    /**
     * @var ConstraintViolation[]
     */
    protected $violations;

    /**
     * ValidationResult constructor.
     * @param ConstraintViolation[] $violations
     */
    public function __construct(iterable $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolation[]
     */
    public function getViolations(): iterable
    {
        return $this->violations;
    }

    /**
     * @param ConstraintViolation[] $violations
     */
    public function setViolations(iterable $violations): void
    {
        $this->violations = $violations;
    }

    public function hasViolations(): bool
    {
        return count($this->violations) > 0;
    }

}