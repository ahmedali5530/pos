<?php


namespace App\Core\Dto\Common\User;


use App\Core\Dto\Common\Common\StoresDtoTrait;
use App\Core\Dto\Common\Common\UuidDtoTrait;
use App\Entity\User;

class UserDto
{
    use UuidDtoTrait;
    use StoresDtoTrait;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $displayName;

    /**
     * @var string[]
     */
    private $roles = [];

    /**
     * @var string|null
     */
    private $email;

    public static function createFromUser(?User $user): ?self
    {
        if($user === null){
            return null;
        }

        $dto = new self();
        $dto->id = $user->getId();
        $dto->username = $user->getUsername();
        $dto->displayName = $user->getDisplayName();
        $dto->roles = $user->getRoles();
        $dto->email = $user->getEmail();
        $dto->uuid = $user->getUuid();

        $dto->setStores($user->getStores());

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string|null $displayName
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
