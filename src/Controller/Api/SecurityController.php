<?php

namespace App\Controller\Api;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Core\Dto\Controller\Api\Auth\LoginRequestDto;

/**
 * Class SecurityController
 * @package App\Controller\Api
 * @OA\Tag(name="Auth")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/auth/login", name="app_login", methods={"POST"})
     *
     * @OA\RequestBody(
     *     required=true,
     *     @Model(type=LoginRequestDto::class)
     * )
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
    }

    /**
     * @Route("/auth/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
