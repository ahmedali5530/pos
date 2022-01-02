<?php


namespace App\Core\Cqrs\Traits;



use App\Core\Validation\ConstraintViolation;
use App\Core\Validation\ValidationResult;

trait CqrsResultValidationTrait
{

    /**
     * @var null|ValidationResult
     */
    protected $validationResult;

    /**
     * @var null|string
     */
    protected $validationErrorMessage;


    public static function createFromValidationResult(ValidationResult $validationResult): self
    {
        $commandResult = new self();
        $commandResult->validationResult = $validationResult;

        return $commandResult;
    }

    public static function createFromConstraintViolation(ConstraintViolation $violation): self
    {
        $validationResult = new ValidationResult([$violation]);

        return static::createFromValidationResult($validationResult);
    }

    public static function createFromConstraintViolations(iterable $violations): self
    {
        $list = [];
        foreach($violations as $violation){
            $list[] = new ConstraintViolation($violation->getPropertyPath(), $violation->getMessage());
        }

        $validationResult = new ValidationResult($list);

        return static::createFromValidationResult($validationResult);
    }

    public static function createFromValidationErrorMessage(string $validationErrorMessage): self
    {
        $commandResult = new self();
        $commandResult->validationErrorMessage = $validationErrorMessage;

        return $commandResult;
    }

    /**
     * @return string|ValidationResult|null
     */
    public function getValidationError()
    {
        return isset($this->validationErrorMessage) ? $this->validationErrorMessage : $this->validationResult;
    }

    public function hasValidationError(): bool
    {
        return isset($this->validationResult) && $this->validationResult->hasViolations() || isset($this->validationErrorMessage);
    }

}