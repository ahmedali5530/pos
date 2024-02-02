<?php

namespace App\Core\Order\Command\UpdateOrderCommand;

use App\Core\Dto\Common\Discount\DiscountDto;
use App\Core\Dto\Common\Order\OrderPaymentDto;
use App\Core\Dto\Common\Tax\TaxDto;

class UpdateOrderCommand
{
    private $id = null;

    private $orderId = null;

    private $status = null;

    private $description = null;

    private $adjustment = null;

    /**
     * @var int|null
     */
    private $customerId;

    /**
     * @var string|null
     */
    private $customer;

    /**
     * @var DiscountDto|null
     */
    private $discount;

    /**
     * @var string|null
     */
    private $discountAmount;

    /**
     * @var TaxDto|null
     */
    private $tax;

    /**
     * @var float|null
     */
    private $taxAmount;

    /**
     * @var OrderPaymentDto[]
     */
    private $payments = [];

    /**
     * @var string|null
     */
    private $discountRateType;

    /**
     * @var int|null
     */
    private $terminal;

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param null $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getAdjustment()
    {
        return $this->adjustment;
    }

    /**
     * @param null $adjustment
     */
    public function setAdjustment($adjustment): void
    {
        $this->adjustment = $adjustment;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(?int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(?string $customer): void
    {
        $this->customer = $customer;
    }

    public function getDiscount(): ?DiscountDto
    {
        return $this->discount;
    }

    public function setDiscount(?DiscountDto $discount): void
    {
        $this->discount = $discount;
    }

    public function getDiscountAmount(): ?string
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount(?string $discountAmount): void
    {
        $this->discountAmount = $discountAmount;
    }

    public function getTax(): ?TaxDto
    {
        return $this->tax;
    }

    public function setTax(?TaxDto $tax): void
    {
        $this->tax = $tax;
    }

    public function getTaxAmount(): ?float
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(?float $taxAmount): void
    {
        $this->taxAmount = $taxAmount;
    }

    public function getPayments(): array
    {
        return $this->payments;
    }

    public function setPayments(array $payments): void
    {
        $this->payments = $payments;
    }

    public function getDiscountRateType(): ?string
    {
        return $this->discountRateType;
    }

    public function setDiscountRateType(?string $discountRateType): void
    {
        $this->discountRateType = $discountRateType;
    }

    public function getTerminal(): ?int
    {
        return $this->terminal;
    }

    public function setTerminal(?int $terminal): void
    {
        $this->terminal = $terminal;
    }
}
