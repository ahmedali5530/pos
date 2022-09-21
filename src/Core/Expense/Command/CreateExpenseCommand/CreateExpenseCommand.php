<?php

namespace App\Core\Expense\Command\CreateExpenseCommand;

use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Entity\User;

class CreateExpenseCommand
{
    use StoreDtoTrait;

    /**
     * @var null|float
     */
    private $amount = null;

    /**
     * @var null|string
     */
    private $description = null;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
