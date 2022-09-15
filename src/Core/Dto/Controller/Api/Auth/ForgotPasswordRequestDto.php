<?php


namespace App\Core\Dto\Controller\Api\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ForgotPasswordRequestDto
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $username;

    public static function createFromRequest(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new self();
        $dto->username = $data['username'] ?? null;

        return $dto;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}
