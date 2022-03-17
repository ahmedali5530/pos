<?php


namespace App\Controller\Api\Admin;


use App\Core\Dto\Controller\Api\Admin\Order\CreateOrderRequestDto;
use App\Core\Dto\Controller\Api\Admin\Order\OrderListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Order\OrderRequestListDto;
use App\Core\Dto\Controller\Api\Admin\Order\OrderResponseDto;
use App\Core\Order\Command\CreateOrderCommand\CreateOrderCommand;
use App\Core\Order\Command\CreateOrderCommand\CreateOrderCommandHandler;
use App\Core\Order\Command\CreateOrderCommand\CreateOrderCommandHandlerInterface;
use App\Core\Order\Command\DeleteOrderCommand\DeleteOrderCommand;
use App\Core\Order\Command\DeleteOrderCommand\DeleteOrderCommandHandlerInterface;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQuery;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Order;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class OrderController
 * @package App\Controller\Api\Admin
 * @Route("/admin/order", name="admin_orders_")
 * @OA\Tag(name="Admin")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @OA\Parameter(name="customerId", in="query", description="customer id to search for")
     *
     * @OA\Parameter(name="userId", in="query", description="user id to search for")
     *
     * @OA\Parameter(name="itemId", in="query", description="item id to search for")
     *
     * @OA\Parameter(name="variantId", in="query", description="variant id to search for")
     *
     * @OA\Parameter(name="discount", in="query", description="discount amount to search for")
     *
     * @OA\Parameter(name="tax", in="query", description="tax percent to search for")
     *
     * @OA\Parameter(name="payment", in="query", description="payment amount to search for")
     *
     * @OA\Parameter(name="isSuspended", in="query", description="search for suspended orders")
     *
     * @OA\Parameter(name="isDeleted", in="query", description="search for deleted orders")
     *
     * @OA\Parameter(name="isReturned", in="query", description="search for returned orders")
     *
     * @OA\Parameter(name="orderIds[]", in="query", description="search in orders ids", @OA\Schema(type="array", @OA\Items(type="string")))
     *
     * @OA\Parameter(name="ids[]", in="query", description="search in ids", @OA\Schema(type="array", @OA\Items(type="string")))
     *
     * @OA\Parameter(name="dateTimeFrom", in="query", description="Date of order create start")
     *
     * @OA\Parameter(name="dateTimeTo", in="query", description="Date of order create end")
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=OrderListResponseDto::class)
     * )
     */
    public function list(
        Request $request,
        ApiResponseFactory $responseFactory,
        GetOrdersListQueryHandlerInterface $handler
    )
    {
        $requestDto = OrderRequestListDto::createFromRequest($request);
        $requestDto->setUserId($this->getUser()->getId());

        $query = new GetOrdersListQuery();
        $requestDto->populateQuery($query);

        $result = $handler->handle($query);

        $responseDto = OrderListResponseDto::createFromResult($result);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *     @Model(type=CreateOrderRequestDto::class)
     * )
     *
     * @OA\Response(response="200", description="Order Created", @Model(type=OrderResponseDto::class))
     */
    public function create(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        CreateOrderCommandHandlerInterface $handler
    )
    {
        $requestDto = CreateOrderRequestDto::createFromRequest($request);
        $requestDto->setUserId($this->getUser()->getId());
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateOrderCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            OrderResponseDto::createFromOrder($result->getOrder())
        );
    }


    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     *
     * @OA\Response(response="200", description="Order Created", @Model(type=OrderResponseDto::class))
     */
    public function delete(
        $id,
        ApiResponseFactory $responseFactory,
        DeleteOrderCommandHandlerInterface $handler
    )
    {
        $command = new DeleteOrderCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            OrderResponseDto::createFromOrder($result->getOrder())
        );
    }
}