<?php


namespace App\Core\Validation;


class ConstraintViolation
{
    /**
     * @var string
     */
    protected $propertyPath;

    /**
     * @var string
     */
    protected $message;

    /**
     * ConstraintViolation constructor.
     * @param string $propertyPath
     * @param string $message
     */
    public function __construct(string $propertyPath, string $message)
    {
        $this->propertyPath = $propertyPath;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return $this->propertyPath;
    }

    /**
     * @param string $propertyPath
     */
    public function setPropertyPath(string $propertyPath): void
    {
        $this->propertyPath = $propertyPath;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}