<?php


namespace App\Core\Validation;


use Doctrine\Common\Collections\ArrayCollection;

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
        $this->violations = new ArrayCollection($violations);
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

    public function addViolation(ConstraintViolation $violation)
    {
        $this->violations->add($violation);
    }

    public function hasViolations(): bool
    {
        return count($this->violations) > 0;
    }

    public function removeViolation(ConstraintViolation $violation): void
    {
        $this->violations->removeElement($violation);
    }

}
