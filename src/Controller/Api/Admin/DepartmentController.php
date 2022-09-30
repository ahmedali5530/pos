<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Department\CreateDepartmentRequestDto;
use App\Core\Dto\Controller\Api\Admin\Department\SelectDepartmentListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Department\SelectDepartmentRequestDto;
use App\Core\Dto\Controller\Api\Admin\Department\SelectDepartmentResponseDto;
use App\Core\Dto\Controller\Api\Admin\Department\UpdateDepartmentRequestDto;
use App\Core\Department\Command\CreateDepartmentCommand\CreateDepartmentCommand;
use App\Core\Department\Command\CreateDepartmentCommand\CreateDepartmentCommandHandlerInterface;
use App\Core\Department\Command\DeleteDepartmentCommand\DeleteDepartmentCommand;
use App\Core\Department\Command\DeleteDepartmentCommand\DeleteDepartmentCommandHandlerInterface;
use App\Core\Department\Command\UpdateDepartmentCommand\UpdateDepartmentCommand;
use App\Core\Department\Command\UpdateDepartmentCommand\UpdateDepartmentCommandHandlerInterface;
use App\Core\Department\Query\SelectDepartmentQuery\SelectDepartmentQuery;
use App\Core\Department\Query\SelectDepartmentQuery\SelectDepartmentQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Department;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/department", name="admin_departments_")
 * @OA\Tag(name="Admin")
 */
class DepartmentController extends AbstractController
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
     *   @Model(type=SelectDepartmentListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectDepartmentQueryHandlerInterface $handler)
    {
        $requestDto = SelectDepartmentRequestDto::createFromRequest($request);

        $query = new SelectDepartmentQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectDepartmentListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateDepartmentRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectDepartmentResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateDepartmentCommandHandlerInterface $handler)
    {
        $requestDto = CreateDepartmentRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateDepartmentCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectDepartmentResponseDto::createFromDepartment($result->getDepartment())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectDepartmentResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Department $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Department not found');
        }

        return $responseFactory->json(
            SelectDepartmentResponseDto::createFromDepartment($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateDepartmentRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectDepartmentResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateDepartmentCommandHandlerInterface $handler)
    {
        $requestDto = UpdateDepartmentRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateDepartmentCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectDepartmentResponseDto::createFromDepartment($result->getDepartment())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteDepartmentCommandHandlerInterface $handler)
    {
        $command = new DeleteDepartmentCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
