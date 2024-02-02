<?php

namespace App\Core\Dto\Controller\Api\Admin\Order;

use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Core\Dto\Common\Discount\DiscountDto;
use App\Core\Dto\Common\Order\OrderDiscountDto;
use App\Core\Dto\Common\Order\OrderPaymentDto;
use App\Core\Dto\Common\Order\OrderProductDto;
use App\Core\Dto\Common\Order\OrderTaxDto;
use App\Core\Dto\Common\Product\CartProductDto;
use App\Core\Dto\Common\Product\ProductDto;
use App\Core\Dto\Common\Tax\TaxDto;
use App\Core\Order\Command\CreateOrderCommand\CreateOrderCommand;
use App\Core\Validation\Custom\ConstraintValidEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateOrderRequestDto
{
    use StoreDtoTrait;

    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Customer", class="App\Entity\Customer")
     */
    private $customerId;

    /**
     * @var string|null
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
     * @var int|null
     * @Assert\NotBlank(normalizer="trim")
     * @ConstraintValidEntity(entityName="User", class="App\Entity\User")
     */
    private $userId;

    /**
     * @var CartProductDto[]
     * @Assert\NotBlank(message="Please some items in the cart first!")
     * @Assert\Valid()
     */
    private $items = [];

    /**
     * @var DiscountDto|null
     * @Assert\Valid()
     */
    private $discount;

    /**
     * @var string|null
     */
    private $discountAmount;

    /**
     * @var string|null
     */
    private $discountRateType;

    /**
     * @var TaxDto|null
     * @Assert\Valid()
     */
    private $tax;

    /**
     * @var float|null
     */
    private $taxAmount;

    /**
     * @var OrderPaymentDto[]
     * @Assert\Valid()
     */
    private $payments = [];

    /**
     * @return bool
     * @Assert\IsTrue(message="Please add some payments by clicking on + button")
     */
    public function hasPayments()
    {
        if($this->finalTotal === 0 && count($this->payments) === 0){
            return true;
        }else if($this->finalTotal !== 0 && count($this->payments) === 0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @var float|null
     */
    private $finalTotal;

    /**
     * @var int|null
     */
    private $refundingFrom;

    /**
     * @var string|null
     * @Assert\Type(type="string")
     */
    private $notes;

    /**
     * @var int|null
     * @Assert\NotBlank(normalizer="trim")
     * @ConstraintValidEntity(class="App\Entity\Terminal", entityName="Terminal")
     */
    private $terminal;

    /**
     * @var float|null
     */
    private $adjustment;

    /**
     * @var string|null
     */
    private $status;

    public static function createFromRequest(Request $request)
    {
        $dto = new self();

        $data = json_decode($request->getContent(), true);

        $dto->isSuspended = $data['isSuspended'] ?? null;
        $dto->isDeleted = $data['isDeleted'] ?? null;
        $dto->isReturned = $data['isReturned'] ?? null;
        $dto->isDispatched = $data['isDispatched'] ?? null;

        $dto->customerId = $data['customerId'] ?? null;
        $dto->userId = $data['userId'] ?? null;

        foreach($data['items'] ?? [] as $item){
            $dto->items[] = CartProductDto::createFromArray($item);
        }

        $dto->discount = DiscountDto::createFromArray($data['discount'] ?? null);
        $dto->tax = TaxDto::createFromArray($data['tax'] ?? null);
        $dto->taxAmount = $data['taxAmount'] ?? 0;

        foreach($data['payments'] ?? [] as $item){
            $dto->payments[] = OrderPaymentDto::createFromArray($item);
        }

        $dto->discountAmount = $data['discountAmount'] ?? null;
        $dto->discountRateType = $data['discountRateType'] ?? null;

        $dto->refundingFrom = $data['refundingFrom'] ?? null;
        $dto->notes = $data['notes'] ?? null;

        $dto->store = $data['store'] ?? null;
        $dto->terminal = $data['terminal'] ?? null;

        $dto->finalTotal = $data['total'] ?? 0;
        $dto->adjustment = $data['adjustment'] ?? 0;

        $dto->customer = $data['customer'] ?? null;

        $dto->status = $data['status'] ?? null;

        return $dto;
    }

    public function populateCommand(CreateOrderCommand $command)
    {
        $command->setCustomerId($this->customerId);
        $command->setIsSuspended($this->isSuspended);
        $command->setIsDeleted($this->isDeleted);
        $command->setIsReturned($this->isReturned);
        $command->setIsDispatched($this->isDispatched);
        $command->setUserId($this->userId);
        $command->setItems($this->items);
        $command->setDiscount($this->discount);
        $command->setTax($this->tax);
        $command->setPayments($this->payments);
        $command->setDiscountAmount($this->discountAmount);
        $command->setReturnedFrom($this->refundingFrom);
        $command->setNotes($this->notes);
        $command->setDiscountRateType($this->discountRateType);
        $command->setStore($this->getStore());
        $command->setTerminal($this->terminal);
        $command->setTaxAmount($this->taxAmount);
        $command->setAdjustment($this->adjustment);
        $command->setCustomer($this->customer);
        $command->setStatus($this->status);
    }

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
    public function getRefundingFrom(): ?int
    {
        return $this->refundingFrom;
    }

    /**
     * @param int|null $refundingFrom
     */
    public function setRefundingFrom(?int $refundingFrom): void
    {
        $this->refundingFrom = $refundingFrom;
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
     * @return float|null
     */
    public function getFinalTotal(): ?float
    {
        return $this->finalTotal;
    }

    /**
     * @param float|null $finalTotal
     */
    public function setFinalTotal(?float $finalTotal): void
    {
        $this->finalTotal = $finalTotal;
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

    /**
     * @return float|null
     */
    public function getAdjustment(): ?float
    {
        return $this->adjustment;
    }

    /**
     * @param float|null $adjustment
     */
    public function setAdjustment(?float $adjustment): void
    {
        $this->adjustment = $adjustment;
    }

    /**
     * @return string|null
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    /**
     * @param string|null $customer
     */
    public function setCustomer(?string $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * Get the value of status
     *
     * @return  string|null
     */ 
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  string|null  $status
     *
     * @return  self
     */ 
    public function setStatus(?string $status)
    {
        $this->status = $status;

        return $this;
    }
}