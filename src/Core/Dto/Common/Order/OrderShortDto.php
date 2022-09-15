<?php


namespace App\Core\Dto\Common\Order;


use App\Core\Dto\Common\Customer\CustomerDto;
use App\Core\Dto\Common\User\UserDto;
use App\Entity\Order;
use App\Entity\OrderDiscount;
use App\Entity\OrderTax;

class OrderShortDto
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int|null
     */
    private $orderId;

    /**
     * @var CustomerDto|null
     */
    private $customer;

    /**
     * @var bool|null
     */
    private $isSuspended;

    /**
     * @var bool|null
     */
    private $isDeleted;

    /**
     * @var bool|null
     */
    private $isReturned;

    /**
     * @var bool|null
     */
    private $isDispatched;

    /**
     * @var UserDto|null
     */
    private $user;

    /**
     * @var OrderProductDto[]
     */
    private $items = [];

    /**
     * @var OrderDiscountDto|null
     */
    private $discount;

    /**
     * @var OrderTaxDto|null
     */
    private $tax;

    /**
     * @var OrderPaymentDto[]
     */
    private $payments = [];

    /**
     * @var \DateTimeInterface|null
     */
    private $createdAt;

    /**
     * @var string
     */
    private $status;

    /**
     * @var OrderDto|null
     */
    private $returnedFrom;

    public static function createFromOrder(?Order $order): ?self
    {
        if($order === null){
            return null;
        }

        $dto = new self();
        $dto->id = $order->getId();
        $dto->orderId = $order->getOrderId();
        $dto->isSuspended = $order->getIsSuspended();
        $dto->isDeleted = $order->getIsDeleted();
        $dto->isReturned = $order->getIsReturned();
        $dto->isDispatched = $order->getIsDispatched();
        $dto->user = UserDto::createFromUser($order->getUser());
        foreach($order->getItems() as $item){
            $dto->items[] = OrderProductDto::createFromOrderProduct($item);
        }
        $dto->discount = OrderDiscountDto::createFromOrderDiscount($order->getDiscount());
        $dto->tax = OrderTaxDto::createFromOrderTax($order->getTax());
        foreach($order->getPayments() as $payment){
            $dto->payments[] = OrderPaymentDto::createFromOrderPayment($payment);
        }
        $dto->createdAt = $order->getCreatedAt();
        $dto->status = $order->getStatus();
        $dto->returnedFrom = OrderDto::createFromOrder($order->getReturnedFrom());

        return $dto;
    }

    public function createFromArray(?array $data): ?self
    {
        if($data === null){
            return null;
        }

        $dto = new self();
        $dto->id = $data['id'] ?? null;
        $dto->orderId = $data['orderId'] ?? null;

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
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @param int|null $orderId
     */
    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return CustomerDto|null
     */
    public function getCustomer(): ?CustomerDto
    {
        return $this->customer;
    }

    /**
     * @param CustomerDto|null $customer
     */
    public function setCustomer(?CustomerDto $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return bool|null
     */
    public function getIsSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    /**
     * @param bool|null $isSuspended
     */
    public function setIsSuspended(?bool $isSuspended): void
    {
        $this->isSuspended = $isSuspended;
    }

    /**
     * @return bool|null
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool|null $isDeleted
     */
    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return bool|null
     */
    public function getIsReturned(): ?bool
    {
        return $this->isReturned;
    }

    /**
     * @param bool|null $isReturned
     */
    public function setIsReturned(?bool $isReturned): void
    {
        $this->isReturned = $isReturned;
    }

    /**
     * @return bool|null
     */
    public function getIsDispatched(): ?bool
    {
        return $this->isDispatched;
    }

    /**
     * @param bool|null $isDispatched
     */
    public function setIsDispatched(?bool $isDispatched): void
    {
        $this->isDispatched = $isDispatched;
    }

    /**
     * @return UserDto|null
     */
    public function getUser(): ?UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto|null $user
     */
    public function setUser(?UserDto $user): void
    {
        $this->user = $user;
    }

    /**
     * @return OrderProductDto[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderProductDto[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return OrderDiscountDto|null
     */
    public function getDiscount(): ?OrderDiscountDto
    {
        return $this->discount;
    }

    /**
     * @param OrderDiscountDto|null $discount
     */
    public function setDiscount(?OrderDiscountDto $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return OrderTaxDto|null
     */
    public function getTax(): ?OrderTaxDto
    {
        return $this->tax;
    }

    /**
     * @param OrderTaxDto|null $tax
     */
    public function setTax(?OrderTaxDto $tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return OrderPaymentDto[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param OrderPaymentDto[] $payments
     */
    public function setPayments(array $payments): void
    {
        $this->payments = $payments;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return OrderDto|null
     */
    public function getReturnedFrom(): ?OrderDto
    {
        return $this->returnedFrom;
    }

    /**
     * @param OrderDto|null $returnedFrom
     */
    public function setReturnedFrom(?OrderDto $returnedFrom): void
    {
        $this->returnedFrom = $returnedFrom;
    }
}
