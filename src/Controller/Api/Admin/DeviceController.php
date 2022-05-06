<?php 

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Device\CreateDeviceRequestDto;
use App\Core\Dto\Controller\Api\Admin\Device\SelectDeviceListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Device\SelectDeviceRequestDto;
use App\Core\Dto\Controller\Api\Admin\Device\SelectDeviceResponseDto;
use App\Core\Dto\Controller\Api\Admin\Device\UpdateDeviceRequestDto;
use App\Core\Device\Command\CreateDeviceCommand\CreateDeviceCommand;
use App\Core\Device\Command\CreateDeviceCommand\CreateDeviceCommandHandlerInterface;
use App\Core\Device\Command\DeleteDeviceCommand\DeleteDeviceCommand;
use App\Core\Device\Command\DeleteDeviceCommand\DeleteDeviceCommandHandlerInterface;
use App\Core\Device\Command\UpdateDeviceCommand\UpdateDeviceCommand;
use App\Core\Device\Command\UpdateDeviceCommand\UpdateDeviceCommandHandlerInterface;
use App\Core\Device\Query\SelectDeviceQuery\SelectDeviceQuery;
use App\Core\Device\Query\SelectDeviceQuery\SelectDeviceQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Device;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/device", name="admin_devices_")
 * @OA\Tag(name="Admin")
 */
class DeviceController extends AbstractController
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
     *   @Model(type=SelectDeviceListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectDeviceQueryHandlerInterface $handler)
    {
        $requestDto = SelectDeviceRequestDto::createFromRequest($request);

        $query = new SelectDeviceQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectDeviceListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateDeviceRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectDeviceResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateDeviceCommandHandlerInterface $handler)
    {
        $requestDto = CreateDeviceRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateDeviceCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectDeviceResponseDto::createFromDevice($result->getDevice())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectDeviceResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Device $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Device not found');
        }

        return $responseFactory->json(
            SelectDeviceResponseDto::createFromDevice($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateDeviceRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK", @Model(type=SelectDeviceResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateDeviceCommandHandlerInterface $handler)
    {
        $requestDto = UpdateDeviceRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateDeviceCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectDeviceResponseDto::createFromDevice($result->getDevice())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteDeviceCommandHandlerInterface $handler)
    {
        $command = new DeleteDeviceCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
