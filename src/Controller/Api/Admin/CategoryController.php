<?php 

namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Category\CreateCategoryRequestDto;
use App\Core\Dto\Controller\Api\Admin\Category\SelectCategoryListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Category\SelectCategoryRequestDto;
use App\Core\Dto\Controller\Api\Admin\Category\SelectCategoryResponseDto;
use App\Core\Dto\Controller\Api\Admin\Category\UpdateCategoryRequestDto;
use App\Core\Category\Command\CreateCategoryCommand\CreateCategoryCommand;
use App\Core\Category\Command\CreateCategoryCommand\CreateCategoryCommandHandlerInterface;
use App\Core\Category\Command\DeleteCategoryCommand\DeleteCategoryCommand;
use App\Core\Category\Command\DeleteCategoryCommand\DeleteCategoryCommandHandlerInterface;
use App\Core\Category\Command\UpdateCategoryCommand\UpdateCategoryCommand;
use App\Core\Category\Command\UpdateCategoryCommand\UpdateCategoryCommandHandlerInterface;
use App\Core\Category\Query\SelectCategoryQuery\SelectCategoryQuery;
use App\Core\Category\Query\SelectCategoryQuery\SelectCategoryQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Category;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category", name="admin_categorys_")
 * @OA\Tag(name="Admin")
 */
class CategoryController extends AbstractController
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
     *   @Model(type=SelectCategoryListResponseDto::class), response="200",
     * description="OK"
     * )
     */
    public function list(Request $request, ApiResponseFactory $responseFactory, ApiRequestDtoValidator $requestDtoValidator, SelectCategoryQueryHandlerInterface $handler)
    {
        $requestDto = SelectCategoryRequestDto::createFromRequest($request);

        $query = new SelectCategoryQuery();

        $requestDto->populateQuery($query);

        $list = $handler->handle($query);

        $responseDto = SelectCategoryListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *   @Model(type=CreateCategoryRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectCategoryResponseDto::class)
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
    public function create(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, CreateCategoryCommandHandlerInterface $handler)
    {
        $requestDto = CreateCategoryRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateCategoryCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectCategoryResponseDto::createFromCategory($result->getCategory())
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectCategoryResponseDto::class)
     * )
     *
     * @OA\Response(
     *   response="404", description="Not found"
     * )
     */
    public function getById(Category $entity, ApiResponseFactory $responseFactory)
    {
        if($entity === null){
            return $responseFactory->notFound('Category not found');
        }

        return $responseFactory->json(
            SelectCategoryResponseDto::createFromCategory($entity)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *   @Model(type=UpdateCategoryRequestDto::class)
     * )
     *
     * @OA\Response(
     *   response="200", description="OK",
     * @Model(type=SelectCategoryResponseDto::class)
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
    public function update(Request $request, ApiRequestDtoValidator $requestDtoValidator, ApiResponseFactory $responseFactory, UpdateCategoryCommandHandlerInterface $handler)
    {
        $requestDto = UpdateCategoryRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateCategoryCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            SelectCategoryResponseDto::createFromCategory($result->getCategory())
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
    public function delete($id, ApiResponseFactory $responseFactory, DeleteCategoryCommandHandlerInterface $handler)
    {
        $command = new DeleteCategoryCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}
