<?php

namespace App\Core\Order\Command\CreateOrderCommand;

use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Core\Dto\Common\Discount\DiscountDto;
use App\Core\Dto\Common\Order\OrderPaymentDto;
use App\Core\Dto\Common\Product\CartProductDto;
use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Dto\Common\Tax\TaxDto;

class CreateOrderCommand
{
    use StoreDtoTrait;

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
     * @var CartProductDto[]
     */
    private $items = [];

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
     * @var int|null
     */
    private $returnedFrom;

    /**
     * @var string|null
     */
    private $notes;

    /**
     * @var string|null
     */
    private $discountRateType;

    /**
     * @var int|null
     */
    private $terminal;

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
     * @return CartProductDto[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CartProductDto[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return DiscountDto|null
     */
    public function getDiscount(): ?DiscountDto
    {
        return $this->discount;
    }

    /**
     * @param DiscountDto|null $discount
     */
    public function setDiscount(?DiscountDto $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return TaxDto|null
     */
    public function getTax(): ?TaxDto
    {
        return $this->tax;
    }

    /**
     * @param TaxDto|null $tax
     */
    public function setTax(?TaxDto $tax): void
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
     * @return string|null
     */
    public function getDiscountAmount(): ?string
    {
        return $this->discountAmount;
    }

    /**
     * @param string|null $discountAmount
     */
    public function setDiscountAmount(?string $discountAmount): void
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * @return int|null
     */
    public function getReturnedFrom(): ?int
    {
        return $this->returnedFrom;
    }

    /**
     * @param int|null $returnedFrom
     */
    public function setReturnedFrom(?int $returnedFrom): void
    {
        $this->returnedFrom = $returnedFrom;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @return string|null
     */
    public function getDiscountRateType(): ?string
    {
        return $this->discountRateType;
    }

    /**
     * @param string|null $discountRateType
     */
    public function setDiscountRateType(?string $discountRateType): void
    {
        $this->discountRateType = $discountRateType;
    }

    /**
     * @return int|null
     */
    public function getTerminal(): ?int
    {
        return $this->terminal;
    }

    /**
     * @param int|null $terminal
     */
    public function setTerminal(?int $terminal): void
    {
        $this->terminal = $terminal;
    }

    /**
     * @return float|null
     */
    public function getTaxAmount(): ?float
    {
        return $this->taxAmount;
    }

    /**
     * @param float|null $taxAmount
     */
    public function setTaxAmount(?float $taxAmount): void
    {
        $this->taxAmount = $taxAmount;
    }
}
