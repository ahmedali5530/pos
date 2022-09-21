<?php

namespace App\Core\Dto\Controller\Api\Admin\Expense;

use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Core\Expense\Query\SelectExpenseQuery\SelectExpenseQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectExpenseRequestDto
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
     * @var null|DateTimeDto
     */
    private $dateTimeFrom;

    /**
     * @var null|DateTimeDto
     */
    private $dateTimeTo;

    /**
     * @var null|string
     */
    private $uuid = null;

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

    public function setUuid(?string $uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->amount = $request->query->get('amount');
        $dto->description = $request->query->get('description');
        $dto->isActive = $request->query->get('isActive');
        $dto->createdAt = $request->query->get('createdAt');
        $dto->uuid = $request->query->get('uuid');
        $dto->dateTimeFrom = DateTimeDto::createFromDateTime($request->query->get('dateTimeFrom'));
        $dto->dateTimeTo = DateTimeDto::createFromDateTime($request->query->get('dateTimeTo'));
        $dto->store = $request->query->get('store');

        return $dto;
    }

    public function populateQuery(SelectExpenseQuery $query)
    {
        $query->setId($this->id);
        $query->setAmount($this->amount);
        $query->setDescription($this->description);
        $query->setIsActive($this->isActive);
        $query->setCreatedAt($this->createdAt);
        $query->setUuid($this->uuid);
        $query->setDateTimeFrom($this->dateTimeFrom);
        $query->setDateTimeTo($this->dateTimeTo);
        $query->setStore($this->store);
    }
}
