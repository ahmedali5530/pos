<?php

namespace App\Core\Dto\Controller\Api\Admin\Customer;

use App\Core\Customer\Query\SelectCustomerQuery\SelectCustomerQuery;
use App\Core\Dto\Common\Common\LimitTrait;
use Symfony\Component\HttpFoundation\Request;

class SelectCustomerRequestDto
{
    use LimitTrait;

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
     * @var null|\DateTimeInterface
     */
    private $createdAt = null;

    /**
     * @var null|string
     */
    private $uuid = null;

    /**
     * @var null|string
     */
    private $q;

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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->id = $request->query->get('id');
        $dto->name = $request->query->get('name');
        $dto->email = $request->query->get('email');
        $dto->phone = $request->query->get('phone');
        $dto->birthday = $request->query->get('birthday');
        $dto->address = $request->query->get('address');
        $dto->lat = $request->query->get('lat');
        $dto->lng = $request->query->get('lng');
        $dto->createdAt = $request->query->get('createdAt');
        $dto->uuid = $request->query->get('uuid');
        $dto->q = $request->query->get('q');
        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');


        return $dto;
    }

    public function populateQuery(SelectCustomerQuery $query)
    {
        $query->setId($this->id);
        $query->setName($this->name);
        $query->setEmail($this->email);
        $query->setPhone($this->phone);
        $query->setBirthday($this->birthday);
        $query->setAddress($this->address);
        $query->setLat($this->lat);
        $query->setLng($this->lng);
        $query->setCreatedAt($this->createdAt);
        $query->setUuid($this->uuid);
        $query->setQ($this->q);
        $query->setLimit($this->limit);
        $query->setOffset($this->offset);
    }
}
