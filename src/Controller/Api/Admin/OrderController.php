<?php


namespace App\Controller\Api\Admin;


use App\Core\Dto\Controller\Api\Admin\Order\CreateOrderRequestDto;
use App\Core\Dto\Controller\Api\Admin\Order\OrderListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Order\OrderRequestListDto;
use App\Core\Dto\Controller\Api\Admin\Order\OrderResponseDto;
use App\Core\Order\Command\CreateOrderCommand\CreateOrderCommand;
use App\Core\Order\Command\CreateOrderCommand\CreateOrderCommandHandlerInterface;
use App\Core\Order\Command\DeleteOrderCommand\DeleteOrderCommand;
use App\Core\Order\Command\DeleteOrderCommand\DeleteOrderCommandHandlerInterface;
use App\Core\Order\Command\DispatchOrderCommand\DispatchOrderCommand;
use App\Core\Order\Command\DispatchOrderCommand\DispatchOrderCommandHandlerInterface;
use App\Core\Order\Command\RefundOrderCommand\RefundOrderCommand;
use App\Core\Order\Command\RefundOrderCommand\RefundOrderCommandHandlerInterface;
use App\Core\Order\Command\RestoreOrderCommand\RestoreOrderCommand;
use App\Core\Order\Command\RestoreOrderCommand\RestoreOrderCommandHandlerInterface;
use App\Core\Order\Command\UpdateOrderCommand\UpdateOrderCommand;
use App\Core\Order\Command\UpdateOrderCommand\UpdateOrderCommandHandlerInterface;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQuery;
use App\Core\Order\Query\GetOrdersListQuery\GetOrdersListQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Order;
use App\Factory\Controller\ApiResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class OrderController
 * @package App\Controller\Api\Admin
 * @Route("/admin/order", name="admin_orders_")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
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
     * @Route("/edit/{id}", methods={"PUT"}, name="edit")
     */
    public function update(
        Order $order,
        ApiResponseFactory $responseFactory,
        UpdateOrderCommandHandlerInterface $updateOrderCommandHandler,
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator
    ){
        $requestDto = CreateOrderRequestDto::createFromRequest($request);
        $requestDto->setUserId($this->getUser()->getId());
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateOrderCommand();
        $command->setId($order->getId());
        $command->setCustomerId($requestDto->getCustomerId());
        $command->setDiscount($requestDto->getDiscount());
        $command->setTax($requestDto->getTax());
        $command->setPayments($requestDto->getPayments());
        $command->setDiscountAmount($requestDto->getDiscountAmount());
        $command->setDescription($requestDto->getNotes());
        $command->setDiscountRateType($requestDto->getDiscountRateType());
        $command->setTerminal($requestDto->getTerminal());
        $command->setTaxAmount($requestDto->getTaxAmount());
        $command->setAdjustment($requestDto->getAdjustment());
        $command->setCustomer($requestDto->getCustomer());
        $command->setStatus($requestDto->getStatus());

        $result = $updateOrderCommandHandler->handle($command);

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
     * @Route("/restore/{id}", methods={"POST"}, name="restore")
     */
    public function restore(
        $id,
        ApiResponseFactory $responseFactory,
        RestoreOrderCommandHandlerInterface $handler
    )
    {
        $command = new RestoreOrderCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            OrderResponseDto::createFromOrder($result->getOrder())
        );
    }

    /**
     * @Route("/dispatch/{id}", methods={"POST"}, name="dispatch")
     */
    public function dispatch(
        $id,
        ApiResponseFactory $responseFactory,
        DispatchOrderCommandHandlerInterface $handler
    )
    {
        $command = new DispatchOrderCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            OrderResponseDto::createFromOrder($result->getOrder())
        );
    }

    /**
     * @Route("/refund/{id}", methods={"POST"}, name="refund")
     */
    public function refund(
        $id,
        ApiResponseFactory $responseFactory,
        RefundOrderCommandHandlerInterface $handler
    )
    {
        $command = new RefundOrderCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            OrderResponseDto::createFromOrder($result->getOrder())
        );
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
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
