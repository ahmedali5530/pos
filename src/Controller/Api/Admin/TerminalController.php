<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Terminal\CreateTerminalRequestDto;
use App\Core\Dto\Controller\Api\Admin\Terminal\SelectTerminalListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Terminal\SelectTerminalRequestDto;
use App\Core\Dto\Controller\Api\Admin\Terminal\SelectTerminalResponseDto;
use App\Core\Dto\Controller\Api\Admin\Terminal\UpdateTerminalRequestDto;
use App\Core\Terminal\Command\CreateTerminalCommand\CreateTerminalCommand;
use App\Core\Terminal\Command\CreateTerminalCommand\CreateTerminalCommandHandlerInterface;
use App\Core\Terminal\Command\DeleteTerminalCommand\DeleteTerminalCommand;
use App\Core\Terminal\Command\DeleteTerminalCommand\DeleteTerminalCommandHandlerInterface;
use App\Core\Terminal\Command\UpdateTerminalCommand\UpdateTerminalCommand;
use App\Core\Terminal\Command\UpdateTerminalCommand\UpdateTerminalCommandHandlerInterface;
use App\Core\Terminal\Query\SelectTerminalQuery\SelectTerminalQuery;
use App\Core\Terminal\Query\SelectTerminalQuery\SelectTerminalQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Terminal;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/terminal", name="admin_terminals_")
 * @OA\Tag(name="Admin")
 */
class TerminalController extends AbstractController
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
     *   @Model(type=SelectTerminalListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectTerminalQueryHandlerInterface $handler)
    {
        $requestDto = SelectTerminalRequestDto::createFromRequest($request);

        $query = new SelectTerminalQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectTerminalListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateTerminalRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectTerminalResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateTerminalCommandHandlerInterface $handler)
    {
        $requestDto = CreateTerminalRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateTerminalCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectTerminalResponseDto::createFromTerminal($result->getTerminal())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectTerminalResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Terminal $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Terminal not found');
        }

        return $responseFactory->json(
            SelectTerminalResponseDto::createFromTerminal($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateTerminalRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectTerminalResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateTerminalCommandHandlerInterface $handler)
    {
        $requestDto = UpdateTerminalRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateTerminalCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectTerminalResponseDto::createFromTerminal($result->getTerminal())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteTerminalCommandHandlerInterface $handler)
    {
        $command = new DeleteTerminalCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
