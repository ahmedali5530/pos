<?php


namespace App\Core\Validation;


use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Validator implements ValidatorInterface
{
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * Validator constructor.
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(\Symfony\Component\Validator\Validator\ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public static function constraintViolationListInterfaceToValidationResult(ConstraintViolationListInterface $violationList): ValidationResult
    {
        $violations = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($violationList as $violation) {
            $constraintViolation = new ConstraintViolation(
                $violation->getPropertyPath(),
                $violation->getMessage()
            );

            $violations[] = $constraintViolation;
        }

        return new ValidationResult($violations);
    }

    public function validate($value, ValidationContext $context = null): ValidationResult
    {
        $context = $context ?? new ValidationContext();

        $violationList = $this->validator->validate($value, null, $context->getGroups());

        return self::constraintViolationListInterfaceToValidationResult($violationList);
    }

}