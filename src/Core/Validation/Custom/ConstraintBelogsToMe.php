<?php


namespace App\Core\Validation\Custom;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation()
 */
class ConstraintBelogsToMe extends Constraint
{
    /**
     * @var string validation message
     */
    public $message = 'Entity of "{{class}}" with ID {{id}} does not belong to you';

    /**
     * @var string The class to be find entity in
     */
    public $class;

    /**
     * @var string the to search for userId
     */
    public $field;

    /**
     * @var string specify which platform we are using, provider, player, coach
     */
    public $platform;
}