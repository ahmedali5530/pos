<?php


namespace App\Core\Cqrs\Traits;


trait CqrsResultEntityNotFoundTrait
{

    /**
     * @var boolean
     */
    protected $isNotFound = false;

    /**
     * @var string|null
     */
    protected $notFoundMessage;


    public static function createNotFound($message = null): self
    {
        $commandResult = new self();
        $commandResult->isNotFound = true;
        $commandResult->notFoundMessage = $message;

        return $commandResult;
    }


    public function isNotFound(): bool
    {
        return $this->isNotFound;
    }

    /**
     * @return string|null
     */
    public function getNotFoundMessage(): ?string
    {
        return $this->notFoundMessage;
    }

    /**
     * @param string|null $notFoundMessage
     */
    public function setNotFoundMessage(?string $notFoundMessage): void
    {
        $this->notFoundMessage = $notFoundMessage;
    }

}