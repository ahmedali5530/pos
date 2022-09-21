<?php


namespace App\Core\Dto\Common\Expense;


use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Dto\Common\Store\StoreDto;
use App\Core\Dto\Common\User\UserDto;
use App\Entity\Expense;

class ExpenseDto
{

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $description;

    /**
     * @var UserDto
     */
    private $user;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @var StoreDto|null
     */
    private $store;

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return UserDto
     */
    public function getUser(): UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto $user
     */
    public function setUser(UserDto $user): void
    {
        $this->user = $user;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return StoreDto|null
     */
    public function getStore(): ?StoreDto
    {
        return $this->store;
    }

    /**
     * @param StoreDto|null $store
     */
    public function setStore(?StoreDto $store): void
    {
        $this->store = $store;
    }

    public static function createFromExpense(Expense $expense): self
    {
        $dto = new self();
        $dto->description = $expense->getDescription();
        $dto->amount = $expense->getAmount();
        $dto->user = UserDto::createFromUser($expense->getUser());
        $dto->createdAt = $expense->getCreatedAt();

        $dto->setStore(StoreDto::createFromStore($expense->getStore()));

        return $dto;
    }
}
