<?php

namespace App\Core\Closing\Command\UpdateClosingCommand;

class UpdateClosingCommand
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
     * @var null|array
     */
    private $data = null;

    /**
     * @var null|array
     */
    private $denominations = null;

    /**
     * @var null|float
     */
    private $expenses = null;

    /**
     * @var int|null
     */
    private $closedBy;

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

    public function setData(?array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setDenominations(?array $denominations)
    {
        $this->denominations = $denominations;
        return $this;
    }

    public function getDenominations()
    {
        return $this->denominations;
    }

    /**
     * @return float|null
     */
    public function getExpenses(): ?float
    {
        return $this->expenses;
    }

    /**
     * @param float|null $expenses
     */
    public function setExpenses(?float $expenses): void
    {
        $this->expenses = $expenses;
    }

    /**
     * @return int|null
     */
    public function getClosedBy(): ?int
    {
        return $this->closedBy;
    }

    /**
     * @param int|null $closedBy
     */
    public function setClosedBy(?int $closedBy): void
    {
        $this->closedBy = $closedBy;
    }
}
