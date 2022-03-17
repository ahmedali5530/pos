<?php


namespace App\Security;


use App\Factory\Controller\ApiResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{

    /**
     * @var ApiResponseFactory
     */
    private $responseFactory;

    public function __construct(
        ApiResponseFactory $responseFactory
    )
    {
        $this->responseFactory = $responseFactory;
    }

    public function onLogoutSuccess(Request $request)
    {
        return $this->responseFactory->json();
    }

}