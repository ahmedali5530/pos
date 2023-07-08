<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\ClosingRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ClosingRepository::class)
 * @ApiResource()
 */
class Closing
{
    use TimestampableTrait;
    use UuidTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $dateTo;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $closedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $closedBy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $openingBalance;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $closingBalance;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cashAdded;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cashWithdrawn;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $openedBy;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $data = [];

    /**
     * @ORM\ManyToOne(targetEntity=Store::class)
     */
    private $store;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $denominations = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $expenses;

    /**
     * @ORM\ManyToOne(targetEntity=Terminal::class)
     */
    private $terminal;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFrom(): ?\DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function setDateFrom(?\DateTimeImmutable $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): ?\DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function setDateTo(?\DateTimeImmutable $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getClosedAt(): ?\DateTimeImmutable
    {
        return $this->closedAt;
    }

    public function setClosedAt(?\DateTimeImmutable $closedAt): self
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    public function getClosedBy(): ?User
    {
        return $this->closedBy;
    }

    public function setClosedBy(?User $closedBy): self
    {
        $this->closedBy = $closedBy;

        return $this;
    }

    public function getOpeningBalance(): ?float
    {
        return $this->openingBalance;
    }

    public function setOpeningBalance(?float $openingBalance): self
    {
        $this->openingBalance = $openingBalance;

        return $this;
    }

    public function getClosingBalance(): ?float
    {
        return $this->closingBalance;
    }

    public function setClosingBalance(?float $closingBalance): self
    {
        $this->closingBalance = $closingBalance;

        return $this;
    }

    public function getCashAdded(): ?float
    {
        return $this->cashAdded;
    }

    public function setCashAdded(?float $cashAdded): self
    {
        $this->cashAdded = $cashAdded;

        return $this;
    }

    public function getCashWithdrawn(): ?float
    {
        return $this->cashWithdrawn;
    }

    public function setCashWithdrawn(?float $cashWithdrawn): self
    {
        $this->cashWithdrawn = $cashWithdrawn;

        return $this;
    }

    public function getOpenedBy(): ?User
    {
        return $this->openedBy;
    }

    public function setOpenedBy(?User $openedBy): self
    {
        $this->openedBy = $openedBy;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getDenominations(): ?array
    {
        return $this->denominations;
    }

    public function setDenominations(?array $denominations): self
    {
        $this->denominations = $denominations;

        return $this;
    }

    public function getExpenses(): ?float
    {
        return $this->expenses;
    }

    public function setExpenses(?float $expenses): self
    {
        $this->expenses = $expenses;

        return $this;
    }

    public function getTerminal(): ?Terminal
    {
        return $this->terminal;
    }

    public function setTerminal(?Terminal $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }
}
