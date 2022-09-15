<?php

namespace App\Core\Dto\Controller\Api\Admin\User;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;
use App\Core\User\Query\SelectUserQuery\SelectUserQuery;
use Symfony\Component\HttpFoundation\Request;

class SelectUserRequestDto
{
    use OrderTrait, LimitTrait, QTrait;

    const ORDERS_LIST = [
        'displayName' => 'User.displayName',
        'username' => 'User.username',
        'roles' => 'User.roles',
        'email' => 'User.email'
    ];

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var null|string
     */
    private $username = null;

    /**
     * @var null|string
     */
    private $displayName = null;

    /**
     * @var null|array
     */
    private $roles = null;

    /**
     * @var null|string
     */
    private $email = null;

    /**
     * @var null|bool
     */
    private $isActive = null;


    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername(?string $username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setDisplayName(?string $displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setRoles(?array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
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

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();

        $dto->displayName = $request->query->get('displayName');
        $dto->roles = $request->query->get('roles');
        $dto->email = $request->query->get('email');
        $dto->isActive = $request->query->get('isActive');

        $dto->limit = $request->query->get('limit');
        $dto->offset = $request->query->get('offset');
        $dto->orderBy = self::ORDERS_LIST[$request->query->get('orderBy')] ?? null;
        $dto->orderMode = $request->query->get('orderMode', 'ASC');
        $dto->q = $request->query->get('q');


        return $dto;
    }

    public function populateQuery(SelectUserQuery $query)
    {
        $query->setDisplayName($this->displayName);
        $query->setRoles($this->roles);
        $query->setEmail($this->email);
        $query->setIsActive($this->isActive);

        $query->setLimit($this->getLimit());
        $query->setOffset($this->getOffset());
        $query->setOrderBy($this->getOrderBy());
        $query->setOrderMode($this->getOrderMode());
        $query->setQ($this->q);
    }
}
