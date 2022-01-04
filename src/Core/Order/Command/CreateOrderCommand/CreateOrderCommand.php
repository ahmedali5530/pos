<?php

namespace App\Core\Order\Command\CreateOrderCommand;

use App\Core\Dto\Common\Order\OrderDiscountDto;
use App\Core\Dto\Common\Order\OrderPaymentDto;
use App\Core\Dto\Common\Order\OrderProductDto;
use App\Core\Dto\Common\Order\OrderTaxDto;

class CreateOrderCommand
{
    /**
     * @var int|null
     */
    private $customerId;

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
     * @var int|null
     */
    private $userId;

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
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     */
    public function setCustomerId(?int $customerId): void
    {
        $this->customerId = $customerId;
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
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
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
}