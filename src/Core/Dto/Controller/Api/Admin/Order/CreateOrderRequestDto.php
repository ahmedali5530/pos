<?php

namespace App\Core\Dto\Controller\Api\Admin\Order;

use App\Core\Dto\Common\Order\OrderDiscountDto;
use App\Core\Dto\Common\Order\OrderPaymentDto;
use App\Core\Dto\Common\Order\OrderProductDto;
use App\Core\Dto\Common\Order\OrderTaxDto;
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
     * @var OrderProductDto[]
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $items = [];

    /**
     * @var OrderDiscountDto|null
     * @Assert\Valid()
     */
    private $discount;

    /**
     * @var OrderTaxDto|null
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
            $dto->items[] = OrderProductDto::createFromArray($item);
        }
        $dto->discount = OrderDiscountDto::createFromArray($data['discount'] ?? null);
        $dto->tax = OrderTaxDto::createFromArray($data['tax'] ?? null);

        foreach($data['payments'] ?? [] as $item){
            $dto->payments[] = OrderPaymentDto::createFromArray($item);
        }

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
    }
}
