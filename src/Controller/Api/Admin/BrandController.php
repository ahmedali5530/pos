<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Brand\CreateBrandRequestDto;
use App\Core\Dto\Controller\Api\Admin\Brand\SelectBrandListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Brand\SelectBrandRequestDto;
use App\Core\Dto\Controller\Api\Admin\Brand\SelectBrandResponseDto;
use App\Core\Dto\Controller\Api\Admin\Brand\UpdateBrandRequestDto;
use App\Core\Brand\Command\CreateBrandCommand\CreateBrandCommand;
use App\Core\Brand\Command\CreateBrandCommand\CreateBrandCommandHandlerInterface;
use App\Core\Brand\Command\DeleteBrandCommand\DeleteBrandCommand;
use App\Core\Brand\Command\DeleteBrandCommand\DeleteBrandCommandHandlerInterface;
use App\Core\Brand\Command\UpdateBrandCommand\UpdateBrandCommand;
use App\Core\Brand\Command\UpdateBrandCommand\UpdateBrandCommandHandlerInterface;
use App\Core\Brand\Query\SelectBrandQuery\SelectBrandQuery;
use App\Core\Brand\Query\SelectBrandQuery\SelectBrandQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Brand;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/brand", name="admin_brands_")
 * @OA\Tag(name="Admin")
 */
class BrandController extends AbstractController
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
     *   @Model(type=SelectBrandListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectBrandQueryHandlerInterface $handler)
    {
        $requestDto = SelectBrandRequestDto::createFromRequest($request);

        $query = new SelectBrandQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectBrandListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateBrandRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectBrandResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateBrandCommandHandlerInterface $handler)
    {
        $requestDto = CreateBrandRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateBrandCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectBrandResponseDto::createFromBrand($result->getBrand())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectBrandResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Brand $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Brand not found');
        }

        return $responseFactory->json(
            SelectBrandResponseDto::createFromBrand($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateBrandRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectBrandResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateBrandCommandHandlerInterface $handler)
    {
        $requestDto = UpdateBrandRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateBrandCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectBrandResponseDto::createFromBrand($result->getBrand())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteBrandCommandHandlerInterface $handler)
    {
        $command = new DeleteBrandCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
