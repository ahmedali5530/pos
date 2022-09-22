<?php

namespace App\Core\Dto\Controller\Api\Admin\Closing;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Closing\Command\CreateClosingCommand\CreateClosingCommand;

class CreateClosingRequestDto
{
    /**
     * @var null|\DateTimeImmutable
     * @Assert\NotBlank(normalizer="trim")
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
     * @Assert\NotBlank(normalizer="trim")
     */
    private $openingBalance = null;

    /**
     * @var null|float
     */
    private $closingBalance = null;

    /**
     * @var null|float
     * @Assert\NotBlank(normalizer="trim")
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
        $data = json_decode($request->getContent(), true);

        $dto->dateFrom = $data['dateFrom'] ?? null;
        $dto->dateTo = $data['dateTo'] ?? null;
        $dto->closedAt = $data['closedAt'] ?? null;
        $dto->openingBalance = $data['openingBalance'] ?? null;
        $dto->closingBalance = $data['closingBalance'] ?? null;
        $dto->cashAdded = $data['cashAdded'] ?? null;
        $dto->cashWithdrawn = $data['cashWithdrawn'] ?? null;
        $dto->data = $data['data'] ?? null;
        $dto->denominations = $data['denominations'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateClosingCommand $command)
    {
        $command->setDateFrom($this->dateFrom);
        $command->setDateTo($this->dateTo);
        $command->setClosedAt($this->closedAt);
        $command->setOpeningBalance($this->openingBalance);
        $command->setClosingBalance($this->closingBalance);
        $command->setCashAdded($this->cashAdded);
        $command->setCashWithdrawn($this->cashWithdrawn);
        $command->setData($this->data);
        $command->setDenominations($this->denominations);
    }
}
