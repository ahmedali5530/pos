<?php

namespace App\Core\Supplier\Query\SelectSupplierQuery;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\Dto\Common\Common\StoreDtoTrait;

class SelectSupplierQuery
{
    use LimitTrait;
    use OrderTrait;
    use QTrait;
    use StoreDtoTrait;

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
     * @var null|\DateTimeInterface
     */
    private $deletedAt = null;

    /**
     * @var null|\DateTimeInterface
     */
    private $updatedAt = null;

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

    public function setDeletedAt(?\DateTimeInterface $deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
}
