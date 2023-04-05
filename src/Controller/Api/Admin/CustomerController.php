<?php

namespace App\Controller\Api\Admin;

use App\Core\Customer\Command\CreatePaymentCommand\CreatePaymentCommand;
use App\Core\Customer\Command\CreatePaymentCommand\CreatePaymentCommandHandlerInterface;
use App\Core\Dto\Controller\Api\Admin\Customer\CreateCustomerPaymentRequestDto;
use App\Core\Dto\Controller\Api\Admin\Customer\SelectCustomerResponseDto;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Factory\Controller\ApiResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/customer", name="admin_customers_")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/payment/{id}", methods={"POST"}, name="add_payment")
     */
    public function addPayment(
        $id, Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        CreatePaymentCommandHandlerInterface $handler
    )
    {
        $requestDto = CreateCustomerPaymentRequestDto::createFromRequest($request);
        if (null !== $violations = $requestDtoValidator->validate($requestDto)) {
            return $responseFactory->validationError($violations);
        }

        $command = new CreatePaymentCommand();
        $command->setAmount($requestDto->getAmount());
        $command->setUser($this->getUser());
        $command->setCustomerId($id);
        $command->setDescription($requestDto->getDescription());
        $command->setOrderId($requestDto->getOrderId());

        $result = $handler->handle($command);

        if ($result->hasValidationError()) {
            return $responseFactory->validationError($result->getValidationError());
        }

        if ($result->isNotFound()) {
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectCustomerResponseDto::createFromCustomer($result->getCustomer())
        );
    }
}
