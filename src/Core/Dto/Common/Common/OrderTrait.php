<?php


namespace App\Core\Dto\Common\Common;


use Symfony\Component\Validator\Constraints as Assert;

trait OrderTrait
{
    /**
     * @var string|null
     * @Assert\Type(type="string")
     * @Assert\Choice(choices={"ASC", "DESC"})
     */
    private $orderMode;

    /**
     * @var string|null
     * @Assert\Type(type="string")
     */
    private $orderBy;

    /**
     * @return string|null
     */
    public function getOrderMode(): ?string
    {
        return $this->orderMode;
    }

    /**
     * @param string|null $orderMode
     */
    public function setOrderMode(?string $orderMode): void
    {
        $this->orderMode = $orderMode;
    }

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param string|null $orderBy
     */
    public function setOrderBy(?string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }
}