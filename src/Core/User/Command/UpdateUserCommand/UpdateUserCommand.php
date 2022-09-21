<?php

namespace App\Core\User\Command\UpdateUserCommand;

class UpdateUserCommand
{
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
    private $password = null;

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
     * @var null|string[]
     */
    private $stores = null;

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

    public function setPassword(?string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
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

    /**
     * @return string[]|null
     */
    public function getStores(): ?array
    {
        return $this->stores;
    }

    /**
     * @param string[]|null $stores
     */
    public function setStores(?array $stores): void
    {
        $this->stores = $stores;
    }
}
