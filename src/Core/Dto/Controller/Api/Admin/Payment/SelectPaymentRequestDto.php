<?php 

namespace App\Core\Dto\Controller\Api\Admin\Payment;

use App\Core\Payment\Query\SelectPaymentQuery\SelectPaymentQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectPaymentRequestDto
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
        $dto->type = $request->query->get('type');
        $dto->canHaveChangeDue = $request->query->get('canHaveChangeDue');
        $dto->isActive = $request->query->get('isActive');
        $dto->createdAt = $request->query->get('createdAt');
        $dto->uuid = $request->query->get('uuid');


        return $dto;
    }

    public function populateQuery(SelectPaymentQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setType($this->type);
        $query->setCanHaveChangeDue($this->canHaveChangeDue);
        $query->setIsActive($this->isActive);
        $query->setCreatedAt($this->createdAt);
        $query->setUuid($this->uuid);
    }
}
