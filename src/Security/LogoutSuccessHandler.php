<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function onLogoutSuccess(Request $request)
    {
        return new JsonResponse(
            $this->serializer->serialize([], 'json', array_merge([
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ], [])),
            200, [], true
        );
    }

}