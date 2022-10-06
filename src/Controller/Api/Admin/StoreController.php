<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Store\CreateStoreRequestDto;
use App\Core\Dto\Controller\Api\Admin\Store\SelectStoreListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Store\SelectStoreRequestDto;
use App\Core\Dto\Controller\Api\Admin\Store\SelectStoreResponseDto;
use App\Core\Dto\Controller\Api\Admin\Store\UpdateStoreRequestDto;
use App\Core\Store\Command\CreateStoreCommand\CreateStoreCommand;
use App\Core\Store\Command\CreateStoreCommand\CreateStoreCommandHandlerInterface;
use App\Core\Store\Command\DeleteStoreCommand\DeleteStoreCommand;
use App\Core\Store\Command\DeleteStoreCommand\DeleteStoreCommandHandlerInterface;
use App\Core\Store\Command\UpdateStoreCommand\UpdateStoreCommand;
use App\Core\Store\Command\UpdateStoreCommand\UpdateStoreCommandHandlerInterface;
use App\Core\Store\Query\SelectStoreQuery\SelectStoreQuery;
use App\Core\Store\Query\SelectStoreQuery\SelectStoreQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Store;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/store", name="admin_stores_")
 * @OA\Tag(name="Admin")
 */
class StoreController extends AbstractController
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
     *   @Model(type=SelectStoreListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectStoreQueryHandlerInterface $handler)
    {
        $requestDto = SelectStoreRequestDto::createFromRequest($request);

        $query = new SelectStoreQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectStoreListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateStoreRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectStoreResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateStoreCommandHandlerInterface $handler)
    {
        $requestDto = CreateStoreRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateStoreCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectStoreResponseDto::createFromStore($result->getStore())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectStoreResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Store $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Store not found');
        }

        return $responseFactory->json(
            SelectStoreResponseDto::createFromStore($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateStoreRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectStoreResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateStoreCommandHandlerInterface $handler)
    {
        $requestDto = UpdateStoreRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateStoreCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectStoreResponseDto::createFromStore($result->getStore())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteStoreCommandHandlerInterface $handler)
    {
        $command = new DeleteStoreCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
