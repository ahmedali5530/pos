<?php

namespace App\Core\Dto\Controller\Api\Admin\Closing;

use App\Core\Closing\Command\UpdateClosingCommand\UpdateClosingCommand;
use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Validation\Custom\ConstraintValidEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateClosingRequestDto
{
    /**
     * @var null|int
     * @Assert\NotBlank(normalizer="trim")
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
     * @var null|string[]
     */
    private $data = null;

    /**
     * @var null|string
     */
    private $denominations = null;

    /**
     * @var null|float
     */
    private $expenses = null;

    /**
     * @var null|int
     * @ConstraintValidEntity(class="App\Entity\User", entityName="User")
     */
    private $closedBy = null;

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

    public function setDenominations(?string $denominations)
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        if(isset($data['dateFrom']['datetime'])) {
            $dto->dateFrom = DateTimeDto::parseWithCarbon($data['dateFrom']['datetime'])->toDateTimeImmutable();
        }

        if(isset($data['dateTo']['datetime'])){
            $dto->dateTo = DateTimeDto::parseWithCarbon($data['dateTo']['datetime'])->toDateTimeImmutable();
        }

        if(isset($data['closedAt']['datetime'])){
            $dto->closedAt = DateTimeDto::parseWithCarbon($data['closedAt']['datetime'])->toDateTimeImmutable();
        }

        $dto->openingBalance = $data['openingBalance'] ?? null;
        $dto->closingBalance = $data['closingBalance'] ?? null;
        $dto->cashAdded = $data['cashAdded'] ?? null;
        $dto->cashWithdrawn = $data['cashWithdrawn'] ?? null;
        $dto->data = $data['data'] ?? null;
        $dto->denominations = $data['denominations'] ?? null;
        $dto->expenses = $data['expenses'] ?? null;
        $dto->closedBy = $data['closedBy'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateClosingCommand $command)
    {
        $command->setId($this->id);
        $command->setDateFrom($this->dateFrom);
        $command->setDateTo($this->dateTo);
        $command->setClosedAt($this->closedAt);
        $command->setOpeningBalance($this->openingBalance);
        $command->setClosingBalance($this->closingBalance);
        $command->setCashAdded($this->cashAdded);
        $command->setCashWithdrawn($this->cashWithdrawn);
        $command->setData($this->data);
        $command->setDenominations($this->denominations);
        $command->setExpenses($this->expenses);
        $command->setClosedBy($this->closedBy);
    }
}
