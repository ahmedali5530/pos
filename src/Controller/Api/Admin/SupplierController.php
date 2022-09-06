<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Supplier\CreateSupplierRequestDto;
use App\Core\Dto\Controller\Api\Admin\Supplier\SelectSupplierListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Supplier\SelectSupplierRequestDto;
use App\Core\Dto\Controller\Api\Admin\Supplier\SelectSupplierResponseDto;
use App\Core\Dto\Controller\Api\Admin\Supplier\UpdateSupplierRequestDto;
use App\Core\Supplier\Command\CreateSupplierCommand\CreateSupplierCommand;
use App\Core\Supplier\Command\CreateSupplierCommand\CreateSupplierCommandHandlerInterface;
use App\Core\Supplier\Command\DeleteSupplierCommand\DeleteSupplierCommand;
use App\Core\Supplier\Command\DeleteSupplierCommand\DeleteSupplierCommandHandlerInterface;
use App\Core\Supplier\Command\UpdateSupplierCommand\UpdateSupplierCommand;
use App\Core\Supplier\Command\UpdateSupplierCommand\UpdateSupplierCommandHandlerInterface;
use App\Core\Supplier\Query\SelectSupplierQuery\SelectSupplierQuery;
use App\Core\Supplier\Query\SelectSupplierQuery\SelectSupplierQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Supplier;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/supplier", name="admin_suppliers_")
 * @OA\Tag(name="Admin")
 */
class SupplierController extends AbstractController
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
     *   @Model(type=SelectSupplierListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectSupplierQueryHandlerInterface $handler)
    {
        $requestDto = SelectSupplierRequestDto::createFromRequest($request);

        $query = new SelectSupplierQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectSupplierListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateSupplierRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectSupplierResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateSupplierCommandHandlerInterface $handler)
    {
        $requestDto = CreateSupplierRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateSupplierCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectSupplierResponseDto::createFromSupplier($result->getSupplier())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectSupplierResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Supplier $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Supplier not found');
        }

        return $responseFactory->json(
            SelectSupplierResponseDto::createFromSupplier($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateSupplierRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectSupplierResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateSupplierCommandHandlerInterface $handler)
    {
        $requestDto = UpdateSupplierRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateSupplierCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectSupplierResponseDto::createFromSupplier($result->getSupplier())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteSupplierCommandHandlerInterface $handler)
    {
        $command = new DeleteSupplierCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
