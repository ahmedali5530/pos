<?php

namespace App\Core\Dto\Controller\Api\Admin\Order;

use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQuery;
use Symfony\Component\HttpFoundation\Request;

class OrderRequestListDto
{
    use LimitTrait;
    use OrderTrait;
    use StoreDtoTrait;

    const ORDERS_LIST = [
        'orderId' => 'entity.orderId',
        'id' => 'entity.id',
        'createdAt' => 'entity.createdAt',
        'customer' => 'customer.name',
        'tax' => 'tax.amount',
        'discount' => 'discount.amount',
        'status' => 'entity.status'
    ];

    /**
     * @var int|null
     */
    private $customerId;

    /**
     * @var int|null
     */
    private $userId;

    /**
     * @var int|null
     */
    private $itemId;

    /**
     * @var int|null
     */
    private $variantId;

    /**
     * @var float|null
     */
    private $discount;

    /**
     * @var float|null
     */
    private $tax;

    /**
     * @var float|null
     */
    private $payment;

    /**
     * @var bool|null
     */
    private $isDeleted;

    /**
     * @var bool|null
     */
    private $isSuspeded;

    /**
     * @var bool|null
     */
    private $isReturned;

    /**
     * @var bool|null
     */
    private $isDispatched;

    /**
     * @var int[]|null
     */
    private $orderIds;

    /**
     * @var int[]|null
     */
    private $ids;

    /**
     * @var DateTimeDto|null
     */
    private $dateTimeFrom;

    /**
     * @var DateTimeDto|null
     */
    private $dateTimeTo;

    /**
     * @var string|null
     */
    private $q;

    /**
     * @return int|null
     */
    public function getCustomerId() : ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     */
    public function setCustomerId(?int $customerId) : void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int|null
     */
    public function getUserId() : ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(?int $userId) : void
    {
        $this->userId = $userId;
    }

    /**
     * @return int|null
     */
    public function getItemId() : ?int
    {
        return $this->itemId;
    }

    /**
     * @param int|null $itemId
     */
    public function setItemId(?int $itemId) : void
    {
        $this->itemId = $itemId;
    }

    /**
     * @return int|null
     */
    public function getVariantId() : ?int
    {
        return $this->variantId;
    }

    /**
     * @param int|null $variantId
     */
    public function setVariantId(?int $variantId) : void
    {
        $this->variantId = $variantId;
    }

    /**
     * @return float|null
     */
    public function getDiscount() : ?float
    {
        return $this->discount;
    }

    /**
     * @param float|null $discount
     */
    public function setDiscount(?float $discount) : void
    {
        $this->discount = $discount;
    }

    /**
     * @return float|null
     */
    public function getTax() : ?float
    {
        return $this->tax;
    }

    /**
     * @param float|null $tax
     */
    public function setTax(?float $tax) : void
    {
        $this->tax = $tax;
    }

    /**
     * @return float|null
     */
    public function getPayment() : ?float
    {
        return $this->payment;
    }

    /**
     * @param float|null $payment
     */
    public function setPayment(?float $payment) : void
    {
        $this->payment = $payment;
    }

    /**
     * @return bool|null
     */
    public function getIsDeleted() : ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool|null $isDeleted
     */
    public function setIsDeleted(?bool $isDeleted) : void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return bool|null
     */
    public function getIsSuspeded() : ?bool
    {
        return $this->isSuspeded;
    }

    /**
     * @param bool|null $isSuspeded
     */
    public function setIsSuspeded(?bool $isSuspeded) : void
    {
        $this->isSuspeded = $isSuspeded;
    }

    /**
     * @return bool|null
     */
    public function getIsReturned() : ?bool
    {
        return $this->isReturned;
    }

    /**
     * @param bool|null $isReturned
     */
    public function setIsReturned(?bool $isReturned) : void
    {
        $this->isReturned = $isReturned;
    }

    /**
     * @return bool|null
     */
    public function getIsDispatched() : ?bool
    {
        return $this->isDispatched;
    }

    /**
     * @param bool|null $isDispatched
     */
    public function setIsDispatched(?bool $isDispatched) : void
    {
        $this->isDispatched = $isDispatched;
    }

    /**
     * @return int[]|null
     */
    public function getOrderIds() : ?array
    {
        return $this->orderIds;
    }

    /**
     * @param int[]|null $orderIds
     */
    public function setOrderIds(?array $orderIds) : void
    {
        $this->orderIds = $orderIds;
    }

    /**
     * @return int[]|null
     */
    public function getIds() : ?array
    {
        return $this->ids;
    }

    /**
     * @param int[]|null $ids
     */
    public function setIds(?array $ids) : void
    {
        $this->ids = $ids;
    }

    /**
     * @return string|null
     */
    public function getQ(): ?string
    {
        return $this->q;
    }

    /**
     * @param string|null $q
     */
    public function setQ(?string $q): void
    {
        $this->q = $q;
    }

    public static function createFromRequest(Request $request)
    {
        $dto = new self();

        $dto->customerId = $request->query->get('customerId');
        $dto->userId = $request->query->get('userId');
        $dto->itemId = $request->query->get('itemId');
        $dto->variantId = $request->query->get('variantId');
        $dto->discount = $request->query->get('discount');
        $dto->tax = $request->query->get('tax');
        $dto->payment = $request->query->get('payment');
        $dto->isDeleted = $request->query->get('isDeleted');
        $dto->isSuspeded = $request->query->get('isSuspeded');
        $dto->isReturned = $request->query->get('isReturned');
        $dto->isDispatched = $request->query->get('isDispatched');
        $dto->orderIds = $request->query->get('orderIds');
        $dto->ids = $request->query->get('ids');
        $dto->setLimit($request->query->get('itemsPerPage', 10));
        $dto->setOffset($request->query->get('page', 1));
        if($request->query->has('order')){

            $orderBy = array_keys($request->query->get('order'))[0];
            $orderMode = array_values($request->query->get('order'))[0];

            $dto->orderBy = self::ORDERS_LIST[$orderBy] ?? null;
            $dto->orderMode = $orderMode ?? 'ASC';
        }

        $dto->dateTimeFrom = DateTimeDto::createFromDateTime($request->query->get('dateTimeFrom'));
        $dto->dateTimeTo = DateTimeDto::createFromDateTime($request->query->get('dateTimeTo'));
        $dto->q = $request->query->get('q');
        $dto->store = $request->query->get('store');

        return $dto;
    }

    public function populateQuery(GetOrdersListQuery $query)
    {
        $query->setLimit($this->getLimit());
        if($this->getOffset() !== null) {
            $query->setOffset(($this->getOffset() - 1) * $this->getLimit());
        }

        $query->setCustomerId($this->customerId);
        $query->setUserId($this->userId);
        $query->setItemId($this->itemId);
        $query->setVariantId($this->variantId);
        $query->setDiscount($this->discount);
        $query->setTax($this->tax);
        $query->setPayment($this->payment);
        $query->setIsDeleted($this->isDeleted);
        $query->setIsSuspeded($this->isSuspeded);
        $query->setIsReturned($this->isReturned);
        $query->setIsDispatched($this->isDispatched);
        $query->setOrderIds($this->orderIds);
        $query->setIds($this->ids);
        $query->setOrderMode($this->orderMode);
        $query->setOrderBy($this->getOrderBy());
        $query->setDateTimeFrom($this->dateTimeFrom);
        $query->setDateTimeTo($this->dateTimeTo);
        $query->setQ($this->q);
        $query->setStore($this->getStore());
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
}
