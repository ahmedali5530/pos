<?php


namespace App\Core\Cqrs\Traits;


trait CqrsResultEntityNotFoundTrait
{

    /**
     * @var boolean
     */
    protected $isNotFound = false;


    public static function createNotFound(): self
    {
        $commandResult = new self();
        $commandResult->isNotFound = true;

        return $commandResult;
    }


    public function isNotFound(): bool
    {
        return $this->isNotFound;
    }

}