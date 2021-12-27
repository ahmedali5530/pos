<?php


namespace App\Core\Validation;


class ValidationContext
{
    /**
     * @var null|iterable
     */
    protected $groups;

    /**
     * @var null|iterable
     */
    protected $data;

    /**
     * @return iterable|null
     */
    public function getGroups(): ?iterable
    {
        return $this->groups;
    }

    /**
     * @param iterable|null $groups
     */
    public function setGroups(?iterable $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @return iterable|null
     */
    public function getData(): ?iterable
    {
        return $this->data;
    }

    /**
     * @param iterable|null $data
     */
    public function setData(?iterable $data): void
    {
        $this->data = $data;
    }

}