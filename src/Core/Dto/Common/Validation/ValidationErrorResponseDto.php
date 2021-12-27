<?php


namespace App\Core\Dto\Common\Validation;


use App\Core\Validation\ConstraintViolation;
use App\Core\Validation\ValidationResult;
use App\Core\Validation\Validator;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorResponseDto
{
    /**
     * @var null|ConstraintViolation[]
     */
    protected $violations;

    /**
     * @var null|string
     */
    protected $errorMessage;

    public static function createFromConstraintViolationList(ConstraintViolationListInterface $violationList): self
    {
        $validationResult = Validator::constraintViolationListInterfaceToValidationResult($violationList);

        return self::createFromValidationResult($validationResult);
    }

    public static function createFromValidationResult(ValidationResult $validationResult): self
    {
        $response = new self();
        $response->violations = $validationResult->getViolations();

        return $response;
    }

    public static function createFromErrorMessage(string $errorMessage): self
    {
        $response = new self();
        $response->errorMessage = $errorMessage;

        return $response;
    }

    /**
     * @return ConstraintViolation[]
     */
    public function getViolations(): ?iterable
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

    /**
     * @return string
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }
}