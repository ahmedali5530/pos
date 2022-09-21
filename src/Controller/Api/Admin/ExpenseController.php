<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Expense\CreateExpenseRequestDto;
use App\Core\Dto\Controller\Api\Admin\Expense\SelectExpenseListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Expense\SelectExpenseRequestDto;
use App\Core\Dto\Controller\Api\Admin\Expense\SelectExpenseResponseDto;
use App\Core\Dto\Controller\Api\Admin\Expense\UpdateExpenseRequestDto;
use App\Core\Expense\Command\CreateExpenseCommand\CreateExpenseCommand;
use App\Core\Expense\Command\CreateExpenseCommand\CreateExpenseCommandHandlerInterface;
use App\Core\Expense\Command\DeleteExpenseCommand\DeleteExpenseCommand;
use App\Core\Expense\Command\DeleteExpenseCommand\DeleteExpenseCommandHandlerInterface;
use App\Core\Expense\Command\UpdateExpenseCommand\UpdateExpenseCommand;
use App\Core\Expense\Command\UpdateExpenseCommand\UpdateExpenseCommandHandlerInterface;
use App\Core\Expense\Query\SelectExpenseQuery\SelectExpenseQuery;
use App\Core\Expense\Query\SelectExpenseQuery\SelectExpenseQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Expense;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/expense", name="admin_expenses_")
 * @OA\Tag(name="Admin")
 */
class ExpenseController extends AbstractController
{
    /**
     * @Route("/list", methods={"GET"}, name="list")
     *
     * @OA\Parameter(
     *   name="dateTimeFrom",
     *   in="query",
     *   description="Search in start date"
     * )
     *
     * @OA\Parameter(
     *   name="dateTimeTo",
     *   in="query",
     *   description="Search in end date"
     * )
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
     * @OA\Parameter(
     *   name="store",
     *   in="query",
     *   description="query in store"
     * )
     *
     * @OA\Response(
     *   @Model(type=SelectExpenseListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectExpenseQueryHandlerInterface $handler)
    {
        $requestDto = SelectExpenseRequestDto::createFromRequest($request);

        $query = new SelectExpenseQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectExpenseListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateExpenseRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectExpenseResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateExpenseCommandHandlerInterface $handler)
    {
        $requestDto = CreateExpenseRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateExpenseCommand();
        $requestDto->populateCommand($command);
        $command->setUser($this->getUser());

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectExpenseResponseDto::createFromExpense($result->getExpense())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectExpenseResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Expense $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Expense not found');
        }

        return $responseFactory->json(
            SelectExpenseResponseDto::createFromExpense($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateExpenseRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectExpenseResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateExpenseCommandHandlerInterface $handler)
    {
        $requestDto = UpdateExpenseRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateExpenseCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectExpenseResponseDto::createFromExpense($result->getExpense())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteExpenseCommandHandlerInterface $handler)
    {
        $command = new DeleteExpenseCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
