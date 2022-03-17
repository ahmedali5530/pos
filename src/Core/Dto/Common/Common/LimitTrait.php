<?php


namespace App\Core\Dto\Common\Common;


use Symfony\Component\Validator\Constraints as Assert;

trait LimitTrait
{
    /**
     * @var int|null
     * @Assert\PositiveOrZero()
     */
    private $limit;

    /**
     * @var int|null
     * @Assert\PositiveOrZero()
     */
    private $offset;

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }
}