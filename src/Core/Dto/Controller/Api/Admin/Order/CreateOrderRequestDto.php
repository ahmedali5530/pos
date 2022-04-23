<?php

namespace App\Core\Dto\Controller\Api\Admin\Order;

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
    /**
     * @var int|null
     * @ConstraintValidEntity(entityName="Customer", class="App\Entity\Customer")
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
     * @Assert\NotBlank(normalizer="trim")
     * @ConstraintValidEntity(entityName="User", class="App\Entity\User")
     */
    private $userId;

    /**
     * @var CartProductDto[]
     * @Assert\NotBlank()
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
     * @var TaxDto|null
     * @Assert\Valid()
     */
    private $tax;

    /**
     * @var OrderPaymentDto[]
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $payments = [];

    /**
     * @var int|null
     */
    private $refundingFrom;

    public static function createFromRequest(Request $request)
    {
        $dto = new self();

        $data = json_decode($request->getContent(), true);

        $dto->customerId = $data['customerId'] ?? null;
        $dto->isSuspended = $data['isSuspended'] ?? null;
        $dto->isDeleted = $data['isDeleted'] ?? null;
        $dto->isReturned = $data['isReturned'] ?? null;
        $dto->isDispatched = $data['isDispatched'] ?? null;
        $dto->userId = $data['userId'] ?? null;
        foreach($data['items'] ?? [] as $item){
            $dto->items[] = CartProductDto::createFromArray($item);
        }
        $dto->discount = DiscountDto::createFromArray($data['discount'] ?? null);
        $dto->tax = TaxDto::createFromArray($data['tax'] ?? null);

        foreach($data['payments'] ?? [] as $item){
            $dto->payments[] = OrderPaymentDto::createFromArray($item);
        }

        $dto->discountAmount = $data['discountAmount'] ?? null;
        $dto->refundingFrom = $data['refundingFrom'] ?? null;

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
}
