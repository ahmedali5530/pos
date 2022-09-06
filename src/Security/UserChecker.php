<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    private RequestStack $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if(!$user->hasRole($this->request->getCurrentRequest()->query->get('role', ''))){
            throw new CustomUserMessageAccountStatusException('Cannot login in this portal', [], Response::HTTP_FORBIDDEN);
        }

        if (!$user->getIsActive()) {
            throw new CustomUserMessageAccountStatusException('Your account is disabled!');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
    }
}
