<?php 

namespace App\Core\Closing\Query\SelectClosingQuery;

class SelectClosingQuery
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|\DateTimeImmutable
     */
    private $dateFrom = null;

    /**
     * @var null|\DateTimeImmutable
     */
    private $dateTo = null;

    /**
     * @var null|\DateTimeImmutable
     */
    private $closedAt = null;

    /**
     * @var null|float
     */
    private $openingBalance = null;

    /**
     * @var null|float
     */
    private $closingBalance = null;

    /**
     * @var null|float
     */
    private $cashAdded = null;

    /**
     * @var null|float
     */
    private $cashWithdrawn = null;

    /**
     * @var null|json
     */
    private $data = null;

    /**
     * @var null|json
     */
    private $denominations = null;

    /**
     * @var null|\DateTimeImmutable
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

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDateFrom(?\DateTimeImmutable $dateFrom)
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    public function setDateTo(?\DateTimeImmutable $dateTo)
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function getDateTo()
    {
        return $this->dateTo;
    }

    public function setClosedAt(?\DateTimeImmutable $closedAt)
    {
        $this->closedAt = $closedAt;
        return $this;
    }

    public function getClosedAt()
    {
        return $this->closedAt;
    }

    public function setOpeningBalance(?float $openingBalance)
    {
        $this->openingBalance = $openingBalance;
        return $this;
    }

    public function getOpeningBalance()
    {
        return $this->openingBalance;
    }

    public function setClosingBalance(?float $closingBalance)
    {
        $this->closingBalance = $closingBalance;
        return $this;
    }

    public function getClosingBalance()
    {
        return $this->closingBalance;
    }

    public function setCashAdded(?float $cashAdded)
    {
        $this->cashAdded = $cashAdded;
        return $this;
    }

    public function getCashAdded()
    {
        return $this->cashAdded;
    }

    public function setCashWithdrawn(?float $cashWithdrawn)
    {
        $this->cashWithdrawn = $cashWithdrawn;
        return $this;
    }

    public function getCashWithdrawn()
    {
        return $this->cashWithdrawn;
    }

    public function setData(?\json $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setDenominations(?\json $denominations)
    {
        $this->denominations = $denominations;
        return $this;
    }

    public function getDenominations()
    {
        return $this->denominations;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt)
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
}
