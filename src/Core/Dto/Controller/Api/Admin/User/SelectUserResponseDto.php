<?php

namespace App\Core\Dto\Controller\Api\Admin\User;

use App\Core\Dto\Common\User\UserDto;
use App\Entity\User;

class SelectUserResponseDto
{
    /**
     * @var UserDto
     */
    private $user = null;

    public static function createFromUser(User $user) : self
    {
        $dto = new self();

        $dto->user = UserDto::createFromUser($user);

        return $dto;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
