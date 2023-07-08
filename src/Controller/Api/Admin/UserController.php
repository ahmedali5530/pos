<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\User\CreateUserRequestDto;
use App\Core\Dto\Controller\Api\Admin\User\SelectUserListResponseDto;
use App\Core\Dto\Controller\Api\Admin\User\SelectUserRequestDto;
use App\Core\Dto\Controller\Api\Admin\User\SelectUserResponseDto;
use App\Core\Dto\Controller\Api\Admin\User\UpdateUserRequestDto;
use App\Core\User\Command\CreateUserCommand\CreateUserCommand;
use App\Core\User\Command\CreateUserCommand\CreateUserCommandHandlerInterface;
use App\Core\User\Command\DeleteUserCommand\DeleteUserCommand;
use App\Core\User\Command\DeleteUserCommand\DeleteUserCommandHandlerInterface;
use App\Core\User\Command\UpdateUserCommand\UpdateUserCommand;
use App\Core\User\Command\UpdateUserCommand\UpdateUserCommandHandlerInterface;
use App\Core\User\Query\SelectUserQuery\SelectUserQuery;
use App\Core\User\Query\SelectUserQuery\SelectUserQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\User;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="admin_users_")
 * @OA\Tag(name="Admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/list", methods={"GET"}, name="list")
     *
     * @OA\Parameter(
     *   name="name",
     *   in="query",
     *   description="Search in name"
     * )
     *
     * @OA\Parameter(
     *   name="limit",
     *   in="query",
     *   description="limit the results"
     * )
     *
     * @OA\Parameter(
     *   name="offset",
     *   in="query",
     *   description="start the results from offset"
     * )
     *
     * @OA\Response(
     *   @Model(type=SelectUserListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectUserQueryHandlerInterface $handler)
    {
        $requestDto = SelectUserRequestDto::createFromRequest($request);

        $query = new SelectUserQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectUserListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateUserRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectUserResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="422", description="Validations"
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateUserCommandHandlerInterface $handler)
    {
        $requestDto = CreateUserRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateUserCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectUserResponseDto::createFromUser($result->getUser())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectUserResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(User $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('User not found');
        }

        return $responseFactory->json(
            SelectUserResponseDto::createFromUser($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateUserRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectUserResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="422", description="Validations"
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateUserCommandHandlerInterface $handler)
    {
        $requestDto = UpdateUserRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateUserCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectUserResponseDto::createFromUser($result->getUser())
        );
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     *
     * @OA\Response(
     *   response="200", description="OK"
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function delete($id, ApiResponseFactory $responseFactory, DeleteUserCommandHandlerInterface $handler)
    {
        $command = new DeleteUserCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
