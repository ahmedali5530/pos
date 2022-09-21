<?php

namespace App\Core\Expense\Query\SelectExpenseQuery;

use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\StoreDtoTrait;

class SelectExpenseQuery
{
    use StoreDtoTrait;

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|float
     */
    private $amount = null;

    /**
     * @var null|string
     */
    private $description = null;

    /**
     * @var null|bool
     */
    private $isActive = null;

    /**
     * @var null|\DateTimeInterface
     */
    private $createdAt = null;

    /**
     * @var null|\DateTimeInterface
     */
    private $deletedAt = null;

    /**
     * @var null|\DateTimeInterface
     */
    private $updatedAt = null;

    /**
     * @var null|string
     */
    private $uuid = null;

    /**
     * @var null|int
     */
    private $limit = null;

    /**
     * @var null|int
     */
    private $offset = null;

    /**
     * @var null|DateTimeDto
     */
    private $dateTimeFrom;

    /**
     * @var null|DateTimeDto
     */
    private $dateTimeTo;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAmount(?float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUuid(?string $uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setOffset(?int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getDateTimeFrom(): ?DateTimeDto
    {
        return $this->dateTimeFrom;
    }

    /**
     * @param DateTimeDto|null $dateTimeFrom
     */
    public function setDateTimeFrom(?DateTimeDto $dateTimeFrom): void
    {
        $this->dateTimeFrom = $dateTimeFrom;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getDateTimeTo(): ?DateTimeDto
    {
        return $this->dateTimeTo;
    }

    /**
     * @param DateTimeDto|null $dateTimeTo
     */
    public function setDateTimeTo(?DateTimeDto $dateTimeTo): void
    {
        $this->dateTimeTo = $dateTimeTo;
    }
}
