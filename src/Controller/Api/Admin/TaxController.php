<?php 

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Tax\CreateTaxRequestDto;
use App\Core\Dto\Controller\Api\Admin\Tax\SelectTaxListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Tax\SelectTaxRequestDto;
use App\Core\Dto\Controller\Api\Admin\Tax\SelectTaxResponseDto;
use App\Core\Dto\Controller\Api\Admin\Tax\UpdateTaxRequestDto;
use App\Core\Tax\Command\CreateTaxCommand\CreateTaxCommand;
use App\Core\Tax\Command\CreateTaxCommand\CreateTaxCommandHandlerInterface;
use App\Core\Tax\Command\DeleteTaxCommand\DeleteTaxCommand;
use App\Core\Tax\Command\DeleteTaxCommand\DeleteTaxCommandHandlerInterface;
use App\Core\Tax\Command\UpdateTaxCommand\UpdateTaxCommand;
use App\Core\Tax\Command\UpdateTaxCommand\UpdateTaxCommandHandlerInterface;
use App\Core\Tax\Query\SelectTaxQuery\SelectTaxQuery;
use App\Core\Tax\Query\SelectTaxQuery\SelectTaxQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Tax;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tax", name="admin_taxs_")
 * @OA\Tag(name="Admin")
 */
class TaxController extends AbstractController
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
     *   @Model(type=SelectTaxListResponseDto::class), response="200", description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectTaxQueryHandlerInterface $handler)
    {
        $requestDto = SelectTaxRequestDto::createFromRequest($request);

        $query = new SelectTaxQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectTaxListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateTaxRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectTaxResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateTaxCommandHandlerInterface $handler)
    {
        $requestDto = CreateTaxRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateTaxCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectTaxResponseDto::createFromTax($result->getTax())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectTaxResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Tax $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Tax not found');
        }

        return $responseFactory->json(
            SelectTaxResponseDto::createFromTax($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateTaxRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectTaxResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateTaxCommandHandlerInterface $handler)
    {
        $requestDto = UpdateTaxRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateTaxCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectTaxResponseDto::createFromTax($result->getTax())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteTaxCommandHandlerInterface $handler)
    {
        $command = new DeleteTaxCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
;