<?php


namespace App\Core\Validation\Custom;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation()
 */
class ConstraintValidEntity extends Constraint
{
    public $message = "'{{entityName}}' with ID '{{id}}' not found";

    public $class;

    public $entityName = 'Entity';

    public $field = 'id';
}
