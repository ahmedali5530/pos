<?php

namespace App\Controller\Api;

use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Core\Dto\Controller\Api\Auth\LoginRequestDto;
use App\Core\Dto\Common\User\UserDto;

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
     * @Route("/auth/info", name="auth_info", methods={"GET"})
     *
     * @OA\Response(
     *     description="User info",
     *     response="200",
     *     @Model(type=UserDto::class)
     * )
     */
    public function info(
        ApiResponseFactory $responseFactory
    )
    {
        $user = $this->getUser();

        if($user === null){
            return $responseFactory->unauthorized();
        }

        return $responseFactory->json(UserDto::createFromUser($user));
    }

    /**
     * @Route("/auth/logout", name="app_logout", methods={"GET"})
     */
    public function logout() {}
}
