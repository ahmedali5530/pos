<?php

namespace App\Controller\Api\Admin;

use App\Core\Customer\Command\CreatePaymentCommand\CreatePaymentCommand;
use App\Core\Customer\Command\CreatePaymentCommand\CreatePaymentCommandHandlerInterface;
use App\Core\Dto\Controller\Api\Admin\Customer\CreateCustomerPaymentRequestDto;
use App\Core\Dto\Controller\Api\Admin\Customer\CreateCustomerRequestDto;
use App\Core\Dto\Controller\Api\Admin\Customer\SelectCustomerListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Customer\SelectCustomerRequestDto;
use App\Core\Dto\Controller\Api\Admin\Customer\SelectCustomerResponseDto;
use App\Core\Dto\Controller\Api\Admin\Customer\UpdateCustomerRequestDto;
use App\Core\Customer\Command\CreateCustomerCommand\CreateCustomerCommand;
use App\Core\Customer\Command\CreateCustomerCommand\CreateCustomerCommandHandlerInterface;
use App\Core\Customer\Command\DeleteCustomerCommand\DeleteCustomerCommand;
use App\Core\Customer\Command\DeleteCustomerCommand\DeleteCustomerCommandHandlerInterface;
use App\Core\Customer\Command\UpdateCustomerCommand\UpdateCustomerCommand;
use App\Core\Customer\Command\UpdateCustomerCommand\UpdateCustomerCommandHandlerInterface;
use App\Core\Customer\Query\SelectCustomerQuery\SelectCustomerQuery;
use App\Core\Customer\Query\SelectCustomerQuery\SelectCustomerQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Customer;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/customer", name="admin_customers_")
 * @OA\Tag(name="Admin")
 */
class CustomerController extends AbstractController
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
     *   @Model(type=SelectCustomerListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(
        Request $request,
        ApiResponseFactory $responseFactory,
        ApiRequestDtoValidator $requestDtoValidator,
        SelectCustomerQueryHandlerInterface $handler
    )
    {
        $requestDto = SelectCustomerRequestDto::createFromRequest($request);

        $query = new SelectCustomerQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectCustomerListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateCustomerRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectCustomerResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateCustomerCommandHandlerInterface $handler)
    {
        $requestDto = CreateCustomerRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateCustomerCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectCustomerResponseDto::createFromCustomer($result->getCustomer())
        );
    }

    /**
     * @Route("/payment/{id}", methods={"POST"}, name="add_payment")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateCustomerRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     *   @Model(type=SelectCustomerResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function addPayment(
        $id, Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        CreatePaymentCommandHandlerInterface $handler
    ){
        $requestDto = CreateCustomerPaymentRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreatePaymentCommand();
        $command->setAmount($requestDto->getAmount());
        $command->setUser($this->getUser());
        $command->setCustomerId($id);
        $command->setDescription($requestDto->getDescription());
        $command->setOrderId($requestDto->getOrderId());

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectCustomerResponseDto::createFromCustomer($result->getCustomer())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK",
     *   @Model(type=SelectCustomerResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Customer $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Customer not found');
        }

        return $responseFactory->json(
            SelectCustomerResponseDto::createFromCustomer($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateCustomerRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectCustomerResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateCustomerCommandHandlerInterface $handler)
    {
        $requestDto = UpdateCustomerRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateCustomerCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectCustomerResponseDto::createFromCustomer($result->getCustomer())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteCustomerCommandHandlerInterface $handler)
    {
        $command = new DeleteCustomerCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
