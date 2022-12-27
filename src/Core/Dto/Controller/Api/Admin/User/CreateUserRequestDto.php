<?php

namespace App\Core\Dto\Controller\Api\Admin\User;

use App\Core\Validation\Custom\ConstraintValidEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\User\Command\CreateUserCommand\CreateUserCommand;

class CreateUserRequestDto
{
    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $username = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $password = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $displayName = null;

    /**
     * @var null|string[]
     * @Assert\NotBlank(normalizer="trim")
     */
    private $roles = null;

    /**
     * @var null|string
     * @Assert\NotBlank(normalizer="trim")
     */
    private $email = null;

    /**
     * @var string[]|null
     * @Assert\All(
     *     @Assert\Type(type="string"),
     *     @ConstraintValidEntity(class="App\Entity\Store", entityName="Group")
     * )
     */
    private $stores;

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

    public static function createFromRequest(Request $request) : self
    {
        $dto = new self();
        $data = json_decode($request->getContent(), true);

        $dto->username = $data['username'] ?? null;
        $dto->password = $data['password'] ?? null;
        $dto->displayName = $data['displayName'] ?? null;
        $dto->roles = $data['roles'] ?? null;
        $dto->email = $data['email'] ?? null;
        $dto->stores = $data['stores'] ?? null;


        return $dto;
    }

    public function populateCommand(CreateUserCommand $command)
    {
        $command->setUsername($this->username);
        $command->setPassword($this->password);
        $command->setDisplayName($this->displayName);
        $command->setRoles($this->roles);
        $command->setEmail($this->email);
        $command->setStores($this->stores);
    }
}
