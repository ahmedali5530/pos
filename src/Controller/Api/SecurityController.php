<?php

namespace App\Controller\Api;

use App\Core\Dto\Common\Common\ResponseDto;
use App\Core\Dto\Controller\Api\Auth\ForgotPasswordRequestDto;
use App\Core\Dto\Controller\Api\Auth\ResetRequestDto;
use App\Entity\User;
use App\Factory\Controller\ApiResponseFactory;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Core\Dto\Controller\Api\Auth\LoginRequestDto;
use App\Core\Dto\Common\User\UserDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Core\Dto\Common\Validation\ValidationErrorResponseDto;

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

        return $responseFactory->json([
            'user' => UserDto::createFromUser($user)
        ]);
    }

    /**
     * @Route("/auth/logout", name="app_logout", methods={"GET"})
     */
    public function logout() {
        return $this->json(null);
    }

    /**
     * @Route("/auth/forgot-password", name="forgot_password", methods={"POST"})
     *
     * @OA\RequestBody(
     *     required=true,
     *     @Model(type=ForgotPasswordRequestDto::class)
     * )
     *
     * @OA\Response(
     *     response="422",
     *     description="Violations",
     *     @Model(type=ValidationDto::class)
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Success",
     *     @OA\Schema(
     *          @OA\Property(property="status", type="boolean"),
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *     )
     * )
     */
    public function forgotPassword(
        Request                $request,
        ValidatorInterface     $validator,
        ApiResponseFactory     $responseFactory,
        EntityManagerInterface $entityManager,
        MailerInterface        $mailer
    )
    {
        $requestDto = ForgotPasswordRequestDto::createFromRequest($request);
        $violations = $validator->validate($requestDto);

        if ($violations->count() > 0) {
            return $responseFactory->validationError($violations);
        }

        $credentials = $entityManager->getRepository(User::class)->findOneBy([
            'username' => $requestDto->getUsername()
        ]);

        if ($credentials === null) {
            return $responseFactory->validationError('Could not find any user with this username/email.');
        }

        //send email
        $credentials->setPasswordResetToken(base64_encode(sprintf(
            '%s%s%s', Uuid::uuid4(), random_bytes(64), Uuid::uuid4()
        )));

        $entityManager->persist($credentials);
        $entityManager->flush();

        //TODO: add email url here

        $email = (new Email())
            ->from('no-reply@gmail.com')
            ->to($credentials->getEmail())
            ->subject('Reset your password')
            ->html(
                <<<HTML
<div>
<h1>Reset your password</h1>
    <p>Please follow the link to reset your password</p>
    <a href="#">Url</a>
</div>
HTML
            );

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            return $responseFactory->validationError($exception->getMessage());
        }

        $response = new ResponseDto();
        $response->setMessage('An email has been sent to you, please follow the instructions');

        return $responseFactory->json($response);
    }

    /**
     * @Route("/auth/reset-password", name="reset_password", methods={"POST"})
     *
     * @OA\RequestBody(
     *     required=true,
     *     @Model(type=ResetRequestDto::class)
     * )
     *
     * @OA\Response(
     *     response="422",
     *     description="Violations",
     *     @Model(type=ValidationErrorResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Success",
     *     @OA\Schema(
     *          @OA\Property(property="status", type="boolean"),
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *     )
     * )
     */
    public function resetPassword(
        Request                     $request,
        ValidatorInterface          $validator,
        ApiResponseFactory          $responseFactory,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $passwordEncoder
    )
    {
        $requestDto = ResetRequestDto::createFromRequest($request);
        $violations = $validator->validate($requestDto);

        if ($violations->count() > 0) {
            return $responseFactory->validationError($violations);
        }

        $credentials = $entityManager->getRepository(User::class)->findOneBy([
            'passwordResetToken' => $requestDto->getResetToken()
        ]);

        if ($credentials === null) {
            return $responseFactory->validationError('Invalid password reset request');
        }

        $credentials->setPasswordResetToken(null);
        $credentials->setPassword(
            $passwordEncoder->hashPassword($credentials, $requestDto->getPassword())
        );

        $entityManager->persist($credentials);
        $entityManager->flush();

        $response = new ResponseDto();
        $response->setMessage('Password reset was successful');

        return $responseFactory->json($response);
    }
}
