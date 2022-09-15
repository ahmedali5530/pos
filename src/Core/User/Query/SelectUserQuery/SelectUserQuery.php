<?php

namespace App\Core\User\Query\SelectUserQuery;

use App\Core\Dto\Common\Common\LimitTrait;
use App\Core\Dto\Common\Common\OrderTrait;
use App\Core\Dto\Common\Common\QTrait;

class SelectUserQuery
{
    use OrderTrait, LimitTrait, QTrait;

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
}
