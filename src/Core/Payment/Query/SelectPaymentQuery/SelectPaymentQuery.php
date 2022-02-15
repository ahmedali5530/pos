<?php 

namespace App\Core\Payment\Query\SelectPaymentQuery;

class SelectPaymentQuery
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
    private $type = null;

    /**
     * @var null|bool
     */
    private $canHaveChangeDue = null;

    /**
     * @var null|bool
     */
    private $isActive = null;

    /**
     * @var null|\DateTimeInterface
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

    /**
     * @var null|int
     */
    private $limit = null;

    /**
     * @var null|int
     */
    private $offset = null;

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

    public function setType(?string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setCanHaveChangeDue(?bool $canHaveChangeDue)
    {
        $this->canHaveChangeDue = $canHaveChangeDue;
        return $this;
    }

    public function getCanHaveChangeDue()
    {
        return $this->canHaveChangeDue;
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

    public function setCreatedAt(?\DateTimeInterface $createdAt)
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

    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setOffset(?int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }
}