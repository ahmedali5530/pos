<?php


namespace App\Core\Dto\Common\Customer;


use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Core\Dto\Common\Order\OrderDto;
use App\Core\Dto\Common\Order\OrderShortDto;
use App\Entity\Customer;
use App\Entity\Payment;

class CustomerDto
{
    use TimestampsDtoTrait;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var DateTimeDto|null
     */
    private $birthday;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var string|null
     */
    private $lng;

    /**
     * @var float|null
     */
    private $sale = 0;

    /**
     * @var float|null
     */
    private $paid = 0;

    /**
     * @var float|null
     */
    private $outstanding = 0;

    /**
     * @var string|null
     */
    private $cnic;

    /**
     * @var CustomerPaymentDto[]
     */
    private $payments = [];

    /**
     * @var OrderShortDto[]
     */
    private $orders = [];

    /**
     * @var string|null
     */
    private $openingBalance;

    public static function createFromCustomer(?Customer $customer): ?self
    {
        if($customer === null){
            return null;
        }

        $dto = new self();
        $dto->id = $customer->getId();
        $dto->name = $customer->getName();
        $dto->email = $customer->getEmail();
        $dto->phone = $customer->getPhone();
        $dto->birthday = DateTimeDto::createFromDateTime($customer->getBirthday());
        $dto->address = $customer->getAddress();
        $dto->lat = $customer->getLat();
        $dto->lng = $customer->getLng();
        foreach($customer->getOrders() as $order){
            foreach($order->getPayments() as $payment){
                if($payment->getType()->getType() === Payment::PAYMENT_TYPE_CREDIT) {
                    $dto->sale += $payment->getReceived();
                }
            }
        }
        $dto->cnic = $customer->getCnic();
        foreach($customer->getPayments() as $payment){
            $dto->paid += $payment->getAmount();
            $dto->payments[] = CustomerPaymentDto::createFromCustomerPayment($payment);
        }

        $dto->outstanding = $dto->sale - $dto->paid;

        foreach($customer->getOrders() as $order){
            $dto->orders[] = OrderShortDto::createFromOrder($order);
        }

        $dto->openingBalance = $customer->getOpeningBalance();

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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return DateTimeDto|null
     */
    public function getBirthday(): ?DateTimeDto
    {
        return $this->birthday;
    }

    /**
     * @param DateTimeDto|null $birthday
     */
    public function setBirthday(?DateTimeDto $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     */
    public function setLat(?float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return string|null
     */
    public function getLng(): ?string
    {
        return $this->lng;
    }

    /**
     * @param string|null $lng
     */
    public function setLng(?string $lng): void
    {
        $this->lng = $lng;
    }

    /**
     * @return float|null
     */
    public function getSale(): ?float
    {
        return $this->sale;
    }

    /**
     * @param float|null $sale
     */
    public function setSale(?float $sale): void
    {
        $this->sale = $sale;
    }

    /**
     * @return float|null
     */
    public function getPaid(): ?float
    {
        return $this->paid;
    }

    /**
     * @param float|null $paid
     */
    public function setPaid(?float $paid): void
    {
        $this->paid = $paid;
    }

    /**
     * @return float|null
     */
    public function getOutstanding(): ?float
    {
        return $this->outstanding;
    }

    /**
     * @param float|null $outstanding
     */
    public function setOutstanding(?float $outstanding): void
    {
        $this->outstanding = $outstanding;
    }

    /**
     * @return string|null
     */
    public function getCnic(): ?string
    {
        return $this->cnic;
    }

    /**
     * @param string|null $cnic
     */
    public function setCnic(?string $cnic): void
    {
        $this->cnic = $cnic;
    }

    /**
     * @return CustomerPaymentDto[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param CustomerPaymentDto[] $payments
     */
    public function setPayments(array $payments): void
    {
        $this->payments = $payments;
    }

    /**
     * @return OrderShortDto[]
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * @param OrderShortDto[] $orders
     */
    public function setOrders(array $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @return string|null
     */
    public function getOpeningBalance(): ?string
    {
        return $this->openingBalance;
    }

    /**
     * @param string|null $openingBalance
     */
    public function setOpeningBalance(?string $openingBalance): void
    {
        $this->openingBalance = $openingBalance;
    }
}
