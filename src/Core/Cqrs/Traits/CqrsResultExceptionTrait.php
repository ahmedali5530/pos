<?php


namespace App\Core\Cqrs\Traits;


trait CqrsResultExceptionTrait
{
    /**
     * @var \Exception
     */
    protected $exception;


    public static function createFromException(\Exception $exception): self
    {
        $result = new self();
        $result->exception = $exception;

        return $result;
    }


    public function getException(): \Exception
    {
        return $this->exception;
    }

    public function hasException(): bool
    {
        return null !== $this->exception;
    }
}