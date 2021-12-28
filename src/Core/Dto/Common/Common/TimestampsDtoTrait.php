<?php


namespace App\Core\Dto\Common\Common;


trait TimestampsDtoTrait
{
    /**
     * @var DateTimeDto|null
     */
    private $createdAt;

    /**
     * @var DateTimeDto|null
     */
    private $updatedAt;

    /**
     * @return DateTimeDto|null
     */
    public function getCreatedAt(): ?DateTimeDto
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeDto|null $createdAt
     */
    public function setCreatedAt(?DateTimeDto $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getUpdatedAt(): ?DateTimeDto
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeDto|null $updatedAt
     */
    public function setUpdatedAt(?DateTimeDto $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}