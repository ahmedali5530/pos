<?php


namespace App\Core\Dto\Common\Customer;


use App\Core\Dto\Common\Order\OrderDto;
use App\Entity\CustomerPayment;

class CustomerPaymentDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var OrderDto|null
     */
    private $order;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
     * @return OrderDto|null
     */
    public function getOrder(): ?OrderDto
    {
        return $this->order;
    }

    /**
     * @param OrderDto|null $order
     */
    public function setOrder(?OrderDto $order): void
    {
        $this->order = $order;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
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
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public static function createFromCustomerPayment(?CustomerPayment $customerPayment): ?self
    {
        if($customerPayment === null){
            return null;
        }

        $dto = new self();

        $dto->id = $customerPayment->getId();
        $dto->amount = $customerPayment->getAmount();
        $dto->order = OrderDto::createFromOrder($customerPayment->getOrder());
        $dto->description = $customerPayment->getDescription();
        $dto->createdAt = $customerPayment->getCreatedAt();

        return $dto;
    }

    public static function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();

        $dto->id = $data['id'] ?? null;
        $dto->amount = $data['amount'] ?? null;
        $dto->description = $data['description'] ?? null;

        return $dto;
    }
}