<?php 

namespace App\Core\Dto\Controller\Api\Admin\Tax;

use App\Core\Tax\Query\SelectTaxQuery\SelectTaxQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectTaxRequestDto
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
     * @var null|float
     */
    private $rate = null;

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

    public function setRate(?float $rate)
    {
        $this->rate = $rate;
        return $this;
    }

    public function getRate()
    {
        return $this->rate;
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
        $dto->rate = $request->query->get('rate');
        $dto->isActive = $request->query->get('isActive');
        $dto->createdAt = $request->query->get('createdAt');
        $dto->uuid = $request->query->get('uuid');


        return $dto;
    }

    public function populateQuery(SelectTaxQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setRate($this->rate);
        $query->setIsActive($this->isActive);
        $query->setCreatedAt($this->createdAt);
        $query->setUuid($this->uuid);
    }
}
