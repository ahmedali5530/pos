<?php


namespace App\Core\Dto\Common\Order;


use App\Core\Validation\Custom\ConstraintValidEntity;
use App\Entity\OrderPayment;

class OrderPaymentDto
{
    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Order payment", class="App\Entity\OrderPayment")
     */
    private $id;

    /**
     * @var float|null
     */
    private $total;

    /**
     * @var float|null
     */
    private $received;

    /**
     * @var float|null
     */
    private $due;

    /**
     * @var string|null
     */
    private $type;


    public static function createFromOrderPayment(?OrderPayment $orderPayment): ?self
    {
        if($orderPayment === null){
            return null;
        }

        $dto = new self();
        $dto->id = $orderPayment->getId();
        $dto->total = $orderPayment->getTotal();
        $dto->received = $orderPayment->getReceived();
        $dto->due = $orderPayment->getDue();
        $dto->type = $orderPayment->getType();

        return $dto;
    }

    public static function createFromArray($data)
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->total = $data['total'] ?? null;
        $dto->received = $data['received'] ?? null;
        $dto->due = $data['due'] ?? null;
        $dto->type = $data['type'] ?? null;

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float|null $total
     */
    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return float|null
     */
    public function getReceived(): ?float
    {
        return $this->received;
    }

    /**
     * @param float|null $received
     */
    public function setReceived(?float $received): void
    {
        $this->received = $received;
    }

    /**
     * @return float|null
     */
    public function getDue(): ?float
    {
        return $this->due;
    }

    /**
     * @param float|null $due
     */
    public function setDue(?float $due): void
    {
        $this->due = $due;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}