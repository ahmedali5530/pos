<?php

namespace App\Core\Dto\Controller\Api\Admin\Closing;

use App\Core\Closing\Query\SelectClosingQuery\SelectClosingQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectClosingRequestDto
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
     * @var null|string
     */
    private $data = null;

    /**
     * @var null|string
     */
    private $denominations = null;

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

    public function setData(?string $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setDenominations(?string $denominations)
    {
        $this->denominations = $denominations;
        return $this;
    }

    public function getDenominations()
    {
        return $this->denominations;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->dateFrom = $request->query->get('dateFrom');
        $dto->dateTo = $request->query->get('dateTo');
        $dto->closedAt = $request->query->get('closedAt');
        $dto->openingBalance = $request->query->get('openingBalance');
        $dto->closingBalance = $request->query->get('closingBalance');
        $dto->cashAdded = $request->query->get('cashAdded');
        $dto->cashWithdrawn = $request->query->get('cashWithdrawn');
        $dto->data = $request->query->get('data');
        $dto->denominations = $request->query->get('denominations');


        return $dto;
    }

    public function populateQuery(SelectClosingQuery $query)
    {
        $query->setId($this->id);
        $query->setDateFrom($this->dateFrom);
        $query->setDateTo($this->dateTo);
        $query->setClosedAt($this->closedAt);
        $query->setOpeningBalance($this->openingBalance);
        $query->setClosingBalance($this->closingBalance);
        $query->setCashAdded($this->cashAdded);
        $query->setCashWithdrawn($this->cashWithdrawn);
        $query->setData($this->data);
        $query->setDenominations($this->denominations);
    }
}
