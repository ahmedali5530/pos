<?php


namespace App\Core\Validation;


use App\Core\Dto\Common\Validation\ValidationErrorResponseDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiRequestDtoValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ApiRequestDtoValidator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }


    public function validate($requestDto, $groups = null): ?ValidationErrorResponseDto
    {
        $violationList = $this->validator->validate($requestDto, null, $groups);

        if ($violationList->count() <= 0) {
            return null;
        }

        return ValidationErrorResponseDto::createFromConstraintViolationList($violationList);
    }
}