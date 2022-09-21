<?php

namespace App\Core\User\Command\CreateUserCommand;

class CreateUserCommand
{
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
    private $salt = null;

    /**
     * @var null|string
     */
    private $displayName = null;

    /**
     * @var null|string
     */
    private $verificationToken = null;

    /**
     * @var null|string
     */
    private $passwordResetToken = null;

    /**
     * @var null|array
     */
    private $roles = null;

    /**
     * @var null|string
     */
    private $email = null;

    /**
     * @var string[]|null
     */
    private $stores = null;

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

    public function setSalt(?string $salt)
    {
        $this->salt = $salt;
        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
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

    public function setVerificationToken(?string $verificationToken)
    {
        $this->verificationToken = $verificationToken;
        return $this;
    }

    public function getVerificationToken()
    {
        return $this->verificationToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken)
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }

    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
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
