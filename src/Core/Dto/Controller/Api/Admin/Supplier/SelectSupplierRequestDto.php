<?php

namespace App\Core\Dto\Controller\Api\Admin\Supplier;

use App\Core\Supplier\Query\SelectSupplierQuery\SelectSupplierQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectSupplierRequestDto
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
    private $phone = null;

    /**
     * @var null|string
     */
    private $email = null;

    /**
     * @var null|string
     */
    private $whatsApp = null;

    /**
     * @var null|string
     */
    private $fax = null;

    /**
     * @var null|string
     */
    private $address = null;

    /**
     * @var null|bool
     */
    private $isActive = null;

    /**
     * @var null|\DateTimeImmutable
     */
    private $createdAt = null;

    /**
     * @var null|string
     */
    private $uuid = null;

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

    public function setPhone(?string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
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

    public function setWhatsApp(?string $whatsApp)
    {
        $this->whatsApp = $whatsApp;
        return $this;
    }

    public function getWhatsApp()
    {
        return $this->whatsApp;
    }

    public function setFax(?string $fax)
    {
        $this->fax = $fax;
        return $this;
    }

    public function getFax()
    {
        return $this->fax;
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

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUuid(?string $uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->name = $request->query->get('name');
        $dto->phone = $request->query->get('phone');
        $dto->email = $request->query->get('email');
        $dto->whatsApp = $request->query->get('whatsApp');
        $dto->fax = $request->query->get('fax');
        $dto->address = $request->query->get('address');



        return $dto;
    }

    public function populateQuery(SelectSupplierQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setPhone($this->phone);
        $query->setEmail($this->email);
        $query->setWhatsApp($this->whatsApp);
        $query->setFax($this->fax);
        $query->setAddress($this->address);
    }
}
