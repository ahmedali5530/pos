<?php

namespace App\Controller\Api;

use App\Core\Dto\Common\Common\ResponseDto;
use App\Core\Dto\Controller\Api\Auth\ForgotPasswordRequestDto;
use App\Core\Dto\Controller\Api\Auth\ResetRequestDto;
use App\Entity\User;
use App\Factory\Controller\ApiResponseFactory;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Core\Dto\Common\User\UserDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SecurityController
 * @package App\Controller\Api
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/auth/login", name="app_login", methods={"POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
    }

    /**
     * @Route("/auth/info", name="auth_info", methods={"GET"})
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
