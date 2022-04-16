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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    public const LOGIN_ROUTE = 'api_app_login';

    private UrlGeneratorInterface $urlGenerator;

    private $apiResponseFactory;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        ApiResponseFactory $responseFactory
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->apiResponseFactory = $responseFactory;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return $this->apiResponseFactory->json([

        ], Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('authorization');
    }

    public function authenticate(Request $request): Passport
    {
        dd();
        $loginRequest = LoginRequestDto::createFromRequest($request);

        $username = $loginRequest->getUsername();

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($loginRequest->getPassword()),
            [
                new RememberMeBadge()
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return $this->apiResponseFactory->json([
            'status' => true,
            'message' => 'OK',
            'data' => UserDto::createFromUser($token->getUser())
        ]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return $this->apiResponseFactory->json([
            'status' => false,
            'message' => $exception->getMessageKey()
        ], Response::HTTP_UNAUTHORIZED);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
