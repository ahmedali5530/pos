<?php


namespace App\Core\Dto\Common\Customer;


use App\Core\Dto\Common\Common\DateTimeDto;
use App\Core\Dto\Common\Common\TimestampsDtoTrait;
use App\Entity\Customer;

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
}