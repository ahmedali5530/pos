<?php

namespace App\Core\Dto\Controller\Api\Admin\User;

use App\Core\User\Command\UpdateUserCommand\UpdateUserCommand;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserRequestDto
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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->id = $data['id'] ?? null;
        $dto->username = $data['username'] ?? null;
        $dto->password = $data['password'] ?? null;
        $dto->displayName = $data['displayName'] ?? null;
        $dto->roles = $data['roles'] ?? null;
        $dto->email = $data['email'] ?? null;


        return $dto;
    }

    public function populateCommand(UpdateUserCommand $command)
    {
        $command->setId($this->id);
        $command->setUsername($this->username);
        $command->setPassword($this->password);
        $command->setDisplayName($this->displayName);
        $command->setRoles($this->roles);
        $command->setEmail($this->email);
    }
}
