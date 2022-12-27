<?php

namespace App\Core\Customer\Command\UpdateCustomerCommand;

class UpdateCustomerCommand
{
    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $name = null;

    /**
     * @var null|string
     */
    private $email = null;

    /**
     * @var null|string
     */
    private $phone = null;

    /**
     * @var null|\DateTimeInterface
     */
    private $birthday = null;

    /**
     * @var null|string
     */
    private $address = null;

    /**
     * @var null|float
     */
    private $lat = null;

    /**
     * @var null|float
     */
    private $lng = null;

    /**
     * @var string|null
     */
    private $openingBalance;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail(?string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPhone(?string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setBirthday(?\DateTimeInterface $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setAddress(?string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setLat(?float $lat)
    {
        $this->lat = $lat;
        return $this;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLng(?float $lng)
    {
        $this->lng = $lng;
        return $this;
    }

    public function getLng()
    {
        return $this->lng;
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
