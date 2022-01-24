<?php


namespace App\Controller\Api\Admin;

use App\Core\Discont\Command\CreateDiscountCommand\CreateDiscountCommand;
use App\Core\Discont\Command\CreateDiscountCommand\CreateDiscountCommandHandlerInterface;
use App\Core\Discount\Command\DeleteDiscountCommand\DeleteDiscountCommand;
use App\Core\Discount\Command\DeleteDiscountCommand\DeleteDiscountCommandHandlerInterface;
use App\Core\Discount\Command\UpdateDiscountCommand\UpdateDiscountCommand;
use App\Core\Discount\Command\UpdateDiscountCommand\UpdateDiscountCommandHandlerInterface;
use App\Core\Discount\Query\GetDiscountListQuery\GetDiscountListQuery;
use App\Core\Discount\Query\GetDiscountListQuery\GetDiscountListQueryHandlerInterface;
use App\Core\Dto\Controller\Api\Admin\Discount\CreateDiscountRequestDto;
use App\Core\Dto\Controller\Api\Admin\Discount\DiscountListRequestDto;
use App\Core\Dto\Controller\Api\Admin\Discount\DiscountListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Discount\DiscountResponseDto;
use App\Core\Dto\Controller\Api\Admin\Discount\UpdateDiscountRequestDto;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Discount;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DiscountController
 * @package App\Controller\Api\Admin
 * @Route("/admin/discount", name="admin_discounts_")
 * @OA\Tag(name="Admin")
 */
class DiscountController extends AbstractController
{
    /**
     * @Route("/list", methods={"GET"}, name="list")
     *
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="Search in name"
     * )
     *
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="limit the results"
     * )
     *
     * @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     description="start the results from offset"
     * )
     *
     * @OA\Response(
     *     @Model(type=DiscountListResponseDto::class), response="200", description="OK"
     * )
     */
    public function list(
        Request $request,
        ApiResponseFactory $responseFactory,
        ApiRequestDtoValidator $requestDtoValidator,
        GetDiscountListQueryHandlerInterface $handler
    )
    {
        $requestDto = DiscountListRequestDto::createFromRequest($request);

        $query = new GetDiscountListQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = DiscountListResponseDto::createFromQueryResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *     @Model(type=CreateDiscountRequestDto::class)
     * )
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=DiscountResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="422", description="Validations"
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function create(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        CreateDiscountCommandHandlerInterface $handler
    )
    {
        $requestDto = CreateDiscountRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateDiscountCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            DiscountResponseDto::createFromDiscount($result->getDiscount())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=DiscountResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function getById(
        Discount $discount,
        ApiResponseFactory $responseFactory
    )
    {
        if($discount === null){
            return $responseFactory->notFound('Discount not found');
        }

        return $responseFactory->json(
            DiscountResponseDto::createFromDiscount($discount)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *     @Model(type=UpdateDiscountRequestDto::class)
     * )
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=DiscountResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="422", description="Validations"
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function update(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        UpdateDiscountCommandHandlerInterface $handler
    )
    {
        $requestDto = UpdateDiscountRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateDiscountCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            DiscountResponseDto::createFromDiscount($result->getDiscount())
        );
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     *
     * @OA\Response(
     *     response="200", description="OK"
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function delete(
        $id, ApiResponseFactory $responseFactory,
        DeleteDiscountCommandHandlerInterface $handler
    )
    {
        $command = new DeleteDiscountCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}