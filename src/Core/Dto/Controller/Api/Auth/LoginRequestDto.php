<?php


namespace App\Core\Dto\Controller\Api\Auth;


use OpenApi\Annotations\Property;
use Symfony\Component\HttpFoundation\Request;

class LoginRequestDto
{
    /**
     * @var string|null
     * @Property()
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    public static function createFromRequest(Request $request): self
    {
        $data = json_decode($request->getContent(), true);

        $dto = new self();
        $dto->username = $data['username'] ?? '';
        $dto->password = $data['password'] ?? '';

        return $dto;
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
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}