<?php

namespace App\Security;

use App\Core\Dto\Common\User\UserDto;
use App\Core\Dto\Controller\Api\Auth\LoginRequestDto;
use App\Factory\Controller\ApiResponseFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class ApiAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public const ALLOWED_ROUTES = [
        'api_'
    ];

    const TOKEN_NAME = 'X-AUTH-TOKEN';

    private $apiResponseFactory;

    public function __construct(
        ApiResponseFactory $responseFactory
    )
    {
        $this->apiResponseFactory = $responseFactory;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return $this->apiResponseFactory->json([], Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request): bool
    {
        if($request->headers->has(self::TOKEN_NAME)) {
            foreach (self::ALLOWED_ROUTES as $route) {
                if (str_starts_with($request->attributes->get('_route'), $route)) {
                    return true;
                }
            }

            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        return false;
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->headers->get(self::TOKEN_NAME);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials(''),
            [
                new RememberMeBadge()
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $message = $exception->getMessageKey();
        if($exception instanceof CustomUserMessageAuthenticationException){
            $message = $exception->getMessage();
        }
        return $this->apiResponseFactory->json([
            'status' => false,
            'message' => $message
        ], Response::HTTP_UNAUTHORIZED);
    }
}
