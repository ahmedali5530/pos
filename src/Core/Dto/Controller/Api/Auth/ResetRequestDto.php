<?php


namespace App\Core\Dto\Controller\Api\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ResetRequestDto
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $resetToken;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=5,
     *     max=32
     * )
     */
    private $password;

    public static function createFromRequest(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new self();
        $dto->resetToken = $data['resetToken'] ?? null;
        $dto->password = $data['password'] ?? null;

        return $dto;
    }

    /**
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * @param string|null $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
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
