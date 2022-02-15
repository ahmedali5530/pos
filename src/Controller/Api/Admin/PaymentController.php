<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Payment\CreatePaymentRequestDto;
use App\Core\Dto\Controller\Api\Admin\Payment\SelectPaymentListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Payment\SelectPaymentRequestDto;
use App\Core\Dto\Controller\Api\Admin\Payment\SelectPaymentResponseDto;
use App\Core\Dto\Controller\Api\Admin\Payment\UpdatePaymentRequestDto;
use App\Core\Payment\Command\CreatePaymentCommand\CreatePaymentCommand;
use App\Core\Payment\Command\CreatePaymentCommand\CreatePaymentCommandHandlerInterface;
use App\Core\Payment\Command\DeletePaymentCommand\DeletePaymentCommand;
use App\Core\Payment\Command\DeletePaymentCommand\DeletePaymentCommandHandlerInterface;
use App\Core\Payment\Command\UpdatePaymentCommand\UpdatePaymentCommand;
use App\Core\Payment\Command\UpdatePaymentCommand\UpdatePaymentCommandHandlerInterface;
use App\Core\Payment\Query\SelectPaymentQuery\SelectPaymentQuery;
use App\Core\Payment\Query\SelectPaymentQuery\SelectPaymentQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Payment;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/payment-types", name="admin_payments_")
 * @OA\Tag(name="Admin")
 */
class PaymentController extends AbstractController
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
     *   @Model(type=SelectPaymentListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(
        Request $request,
        ApiResponseFactory $responseFactory,
        SelectPaymentQueryHandlerInterface $handler)
    {
        $requestDto = SelectPaymentRequestDto::createFromRequest($request);

        $query = new SelectPaymentQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectPaymentListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreatePaymentRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectPaymentResponseDto::class)
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
    public function create(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        CreatePaymentCommandHandlerInterface $handler)
    {
        $requestDto = CreatePaymentRequestDto::createFromRequest($request);
        if (null !== $violations = $requestDtoValidator->validate($requestDto)) {
            return $responseFactory->validationError($violations);
        }

        $command = new CreatePaymentCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if ($result->hasValidationError()) {
            return $responseFactory->validationError($result->getValidationError());
        }

        if ($result->isNotFound()) {
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectPaymentResponseDto::createFromPayment($result->getPayment())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectPaymentResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Payment $entity, ApiResponseFactory $responseFactory)
    {
        if ($entity === null) {
            return $responseFactory->notFound('Payment not found');
        }

        return $responseFactory->json(
            SelectPaymentResponseDto::createFromPayment($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdatePaymentRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectPaymentResponseDto::class)
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
    public function update(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        UpdatePaymentCommandHandlerInterface $handler
    )
    {
        $requestDto = UpdatePaymentRequestDto::createFromRequest($request);
        if (null !== $violations = $requestDtoValidator->validate($requestDto)) {
            return $responseFactory->validationError($violations);
        }

        $command = new UpdatePaymentCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if ($result->hasValidationError()) {
            return $responseFactory->validationError($result->getValidationError());
        }

        if ($result->isNotFound()) {
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectPaymentResponseDto::createFromPayment($result->getPayment())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeletePaymentCommandHandlerInterface $handler)
    {
        $command = new DeletePaymentCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if ($result->isNotFound()) {
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
