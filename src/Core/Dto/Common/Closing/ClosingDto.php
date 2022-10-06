<?php

namespace App\Core\Dto\Common\Closing;

use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\IdDtoTrait;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Core\Dto\Common\Store\StoreDto;
use App\Core\Dto\Common\Terminal\TerminalShortDto;
use App\Core\Dto\Common\User\UserDto;
use App\Entity\Closing;

class ClosingDto
{
    use IdDtoTrait, UuidDtoTrait, TimestampsDtoTrait;

    /**
     * @var DateTimeDto
     */
    private $dateFrom;

    /**
     * @var DateTimeDto|null
     */
    private $dateTo;

    /**
     * @var DateTimeDto|null
     */
    private $closedAt;

    /**
     * @var float|null
     */
    private $openingBalance;

    /**
     * @var float|null
     */
    private $closingBalance;

    /**
     * @var float|null
     */
    private $cashAdded;

    /**
     * @var float|null
     */
    private $cashWithdrawn;

    /**
     * @var UserDto
     */
    private $openedBy;

    /**
     * @var UserDto|null
     */
    private $closedBy;

    /**
     * @var string[]|null
     */
    private $data;

    /**
     * @var StoreDto
     */
    private $store;

    /**
     * @var string[]|null
     */
    private $denominations;

    /**
     * @var float|null
     */
    private $expenses;

    /**
     * @var TerminalShortDto|null
     */
    private $terminal;

    /**
     * @return DateTimeDto
     */
    public function getDateFrom(): DateTimeDto
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTimeDto $dateFrom
     */
    public function setDateFrom(DateTimeDto $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getDateTo(): ?DateTimeDto
    {
        return $this->dateTo;
    }

    /**
     * @param DateTimeDto|null $dateTo
     */
    public function setDateTo(?DateTimeDto $dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getClosedAt(): ?DateTimeDto
    {
        return $this->closedAt;
    }

    /**
     * @param DateTimeDto|null $closedAt
     */
    public function setClosedAt(?DateTimeDto $closedAt): void
    {
        $this->closedAt = $closedAt;
    }

    /**
     * @return float|null
     */
    public function getOpeningBalance(): ?float
    {
        return $this->openingBalance;
    }

    /**
     * @param float|null $openingBalance
     */
    public function setOpeningBalance(?float $openingBalance): void
    {
        $this->openingBalance = $openingBalance;
    }

    /**
     * @return float|null
     */
    public function getClosingBalance(): ?float
    {
        return $this->closingBalance;
    }

    /**
     * @param float|null $closingBalance
     */
    public function setClosingBalance(?float $closingBalance): void
    {
        $this->closingBalance = $closingBalance;
    }

    /**
     * @return float|null
     */
    public function getCashAdded(): ?float
    {
        return $this->cashAdded;
    }

    /**
     * @param float|null $cashAdded
     */
    public function setCashAdded(?float $cashAdded): void
    {
        $this->cashAdded = $cashAdded;
    }

    /**
     * @return float|null
     */
    public function getCashWithdrawn(): ?float
    {
        return $this->cashWithdrawn;
    }

    /**
     * @param float|null $cashWithdrawn
     */
    public function setCashWithdrawn(?float $cashWithdrawn): void
    {
        $this->cashWithdrawn = $cashWithdrawn;
    }

    /**
     * @return UserDto
     */
    public function getOpenedBy(): UserDto
    {
        return $this->openedBy;
    }

    /**
     * @param UserDto $openedBy
     */
    public function setOpenedBy(UserDto $openedBy): void
    {
        $this->openedBy = $openedBy;
    }

    /**
     * @return UserDto|null
     */
    public function getClosedBy(): ?UserDto
    {
        return $this->closedBy;
    }

    /**
     * @param UserDto|null $closedBy
     */
    public function setClosedBy(?UserDto $closedBy): void
    {
        $this->closedBy = $closedBy;
    }

    /**
     * @return string[]|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param string[]|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return StoreDto
     */
    public function getStore(): StoreDto
    {
        return $this->store;
    }

    /**
     * @param StoreDto $store
     */
    public function setStore(StoreDto $store): void
    {
        $this->store = $store;
    }

    /**
     * @return string[]|null
     */
    public function getDenominations(): ?array
    {
        return $this->denominations;
    }

    /**
     * @param string[]|null $denominations
     */
    public function setDenominations(?array $denominations): void
    {
        $this->denominations = $denominations;
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
     * @return TerminalShortDto|null
     */
    public function getTerminal(): ?TerminalShortDto
    {
        return $this->terminal;
    }

    /**
     * @param TerminalShortDto|null $terminal
     */
    public function setTerminal(?TerminalShortDto $terminal): void
    {
        $this->terminal = $terminal;
    }

    public static function createFromClosing(?Closing $closing): ?self
    {
        if($closing === null){
            return null;
        }

        $dto = new self();

        $dto->id = $closing->getId();
        $dto->dateFrom = DateTimeDto::createFromDateTime($closing->getDateFrom());
        $dto->dateTo = DateTimeDto::createFromDateTime($closing->getDateTo());
        $dto->closedAt = DateTimeDto::createFromDateTime($closing->getClosedAt());
        $dto->closedBy = UserDto::createFromUser($closing->getClosedBy());
        $dto->openingBalance = $closing->getOpeningBalance();
        $dto->closingBalance = $closing->getClosingBalance();
        $dto->cashAdded = $closing->getCashAdded();
        $dto->cashWithdrawn = $closing->getCashWithdrawn();
        $dto->openedBy = UserDto::createFromUser($closing->getOpenedBy());
        $dto->data = $closing->getData();
        $dto->store = StoreDto::createFromStore($closing->getStore());
        $dto->denominations = $closing->getDenominations();
        $dto->uuid = $closing->getUuid();
        $dto->createdAt = DateTimeDto::createFromDateTime($closing->getCreatedAt());
        $dto->expenses = $closing->getExpenses();
        $dto->terminal = TerminalShortDto::createFromTerminal($closing->getTerminal());

        return $dto;
    }
}
