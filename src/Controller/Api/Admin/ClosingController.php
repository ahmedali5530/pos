<?php

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Closing\CreateClosingRequestDto;
use App\Core\Dto\Controller\Api\Admin\Closing\SelectClosingListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Closing\SelectClosingRequestDto;
use App\Core\Dto\Controller\Api\Admin\Closing\SelectClosingResponseDto;
use App\Core\Dto\Controller\Api\Admin\Closing\UpdateClosingRequestDto;
use App\Core\Closing\Command\CreateClosingCommand\CreateClosingCommand;
use App\Core\Closing\Command\CreateClosingCommand\CreateClosingCommandHandlerInterface;
use App\Core\Closing\Command\DeleteClosingCommand\DeleteClosingCommand;
use App\Core\Closing\Command\DeleteClosingCommand\DeleteClosingCommandHandlerInterface;
use App\Core\Closing\Command\UpdateClosingCommand\UpdateClosingCommand;
use App\Core\Closing\Command\UpdateClosingCommand\UpdateClosingCommandHandlerInterface;
use App\Core\Closing\Query\SelectClosingQuery\SelectClosingQuery;
use App\Core\Closing\Query\SelectClosingQuery\SelectClosingQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Closing;
use App\Factory\Controller\ApiResponseFactory;
use App\Repository\ClosingRepository;
use App\Repository\StoreRepository;
use App\Repository\TerminalRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/closing", name="admin_closings_")
 * @OA\Tag(name="Admin")
 */
class ClosingController extends AbstractController
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
     *   @Model(type=SelectClosingListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectClosingQueryHandlerInterface $handler)
    {
        $requestDto = SelectClosingRequestDto::createFromRequest($request);

        $query = new SelectClosingQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectClosingListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateClosingRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectClosingResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateClosingCommandHandlerInterface $handler)
    {
        $requestDto = CreateClosingRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateClosingCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectClosingResponseDto::createFromClosing($result->getClosing())
        );
    }

    /**
     * @Route("/opened", methods={"GET"}, name="opened")
     *
     * @OA\Parameter(
     *   name="store",
     *   in="query",
     *   description="current store"
     * )
     *
     * @OA\Parameter(
     *   name="terminal",
     *   in="query",
     *   description="current terminal"
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectClosingResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getOpened(
        ApiResponseFactory $responseFactory,
        ClosingRepository $closingRepository,
        Request $request,
        StoreRepository $storeRepository,
        EntityManagerInterface $entityManager,
        TerminalRepository $terminalRepository
    )
    {
        $store = $storeRepository->find($request->query->get('store'));
        $terminal = $terminalRepository->find($request->query->get('terminal'));

        $qb = $closingRepository->createQueryBuilder('closing');
        $qb->andWhere('closing.closedAt IS NULL');
        $qb->join('closing.store', 'store');
        $qb->join('closing.terminal', 'terminal');
        $qb->andWhere('store = :store')->setParameter('store', $store);
        $qb->andWhere('terminal = :terminal')->setParameter('terminal', $terminal);
        $qb->orderBy('closing.id', 'DESC');
        $qb->setMaxResults(1);

        $closing = $qb->getQuery()->getOneOrNullResult();

        if($closing === null){
            //create new closing and return
            $closing = new Closing();
            $closing->setStore($store);
            $closing->setTerminal($terminal);
            $closing->setDateFrom(Carbon::now()->toDateTimeImmutable());
            $closing->setOpenedBy($this->getUser());

            $entityManager->persist($closing);
            $entityManager->flush();
        }

        return $responseFactory->json(SelectClosingResponseDto::createFromClosing($closing));
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectClosingResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Closing $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Closing not found');
        }

        return $responseFactory->json(
            SelectClosingResponseDto::createFromClosing($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateClosingRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectClosingResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateClosingCommandHandlerInterface $handler)
    {
        $requestDto = UpdateClosingRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateClosingCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectClosingResponseDto::createFromClosing($result->getClosing())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteClosingCommandHandlerInterface $handler)
    {
        $command = new DeleteClosingCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
