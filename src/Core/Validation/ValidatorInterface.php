<?php


namespace App\Core\Validation;


interface ValidatorInterface
{

    public function validate($value, ValidationContext $context = null): ValidationResult;

}