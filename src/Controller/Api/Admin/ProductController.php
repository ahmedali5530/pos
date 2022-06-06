<?php


namespace App\Controller\Api\Admin;


use App\Core\Dto\Controller\Api\Admin\Product\CreateProductRequestDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductListRequestDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductResponseDto;
use App\Core\Dto\Controller\Api\Admin\Product\UpdateProductRequestDto;
use App\Core\Dto\Controller\Api\Admin\Product\UploadProductRequestDto;
use App\Core\Product\Command\CreateProductCommand\CreateProductCommand;
use App\Core\Product\Command\CreateProductCommand\CreateProductCommandHandlerInterface;
use App\Core\Product\Command\DeleteProductCommand\DeleteProductCommand;
use App\Core\Product\Command\DeleteProductCommand\DeleteProductCommandHandlerInterface;
use App\Core\Product\Command\UpdateProductCommand\UpdateProductCommand;
use App\Core\Product\Command\UpdateProductCommand\UpdateProductCommandHandlerInterface;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQuery;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Product;
use App\Factory\Controller\ApiResponseFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller\Api\Admin
 * @Route("/admin/product", name="admin_products_")
 * @OA\Tag(name="Admin")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/list", methods={"GET"}, name="list")
     *
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="Search in title, description, category, tags"
     * )
     *
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="Search in title, description, category, tags"
     * )
     *
     * @OA\Parameter(
     *     name="categoryName",
     *     in="query",
     *     description="Search in categoryName"
     * )
     *
     * @OA\Parameter(
     *     name="categoryId",
     *     in="query",
     *     description="Search in categoryId"
     * )
     *
     * @OA\Parameter(
     *     name="priceFrom",
     *     in="query",
     *     description="price start range"
     * )
     *
     * @OA\Parameter(
     *     name="priceTo",
     *     in="query",
     *     description="price end range"
     * )
     *
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="limit the results"
     * )
     *
     * @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     description="start the results from offset"
     * )
     *
     * @OA\Response(
     *     @Model(type=ProductListResponseDto::class), response="200", description="OK"
     * )
     */
    public function list(
        Request $request,
        ApiResponseFactory $responseFactory,
        ApiRequestDtoValidator $requestDtoValidator,
        GetProductsListQueryHandlerInterface $productsListQueryHandler
    )
    {
        $requestDto = ProductListRequestDto::createFromRequest($request);

        $query = new GetProductsListQuery();

        $requestDto->populateQuery($query);

        $list = $productsListQueryHandler->handle($query);

        $responseDto = ProductListResponseDto::createFromResult($list);

        return $responseFactory->json($responseDto);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     *
     * @OA\RequestBody(
     *     @Model(type=CreateProductRequestDto::class)
     * )
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=ProductResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="422", description="Validations"
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function create(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        CreateProductCommandHandlerInterface $handler
    )
    {
        $requestDto = CreateProductRequestDto::createFromRequest($request);
        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new CreateProductCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            ProductResponseDto::createFromProduct($result->getProduct())
        );
    }

    /**
     * @Route("/export", name="download_products", methods={"GET"})
     *
     * @OA\Response(response="200", description="OK")
     */
    public function download(
        ApiResponseFactory $responseFactory,
        GetProductsListQueryHandlerInterface $productsListQueryHandler
    )
    {
        $query = new GetProductsListQuery();
        $list = $productsListQueryHandler->handle($query);

        $fileName = $this->getParameter('kernel.project_dir').'/public/downloads/products.csv';
        $handle = fopen($fileName, 'w+');
        @chmod($fileName, 0777);
        $columns = [
            'ID', 'Name', 'Barcode', 'Base quantity', 'Available',
            'Purchase price', 'Sale price', 'Category', 'Available Quantity', 'Unit', 'Short code'
        ];
        fputcsv($handle, $columns);
        foreach($list->getList() as $item){
            fputcsv($handle, [
                $item->getId(), $item->getName(), $item->getBarcode(),
                $item->getBaseQuantity(), $item->getIsAvailable(),
                $item->getBasePrice(), $item->getCost(), $item->getCategory()->getName(),
                $item->getQuantity(), $item->getUom(), $item->getShortCode()
            ]);
        }

        return $responseFactory->download($fileName);
    }

    /**
     * @Route("/import", name="import_products", methods={"POST"})
     *
     * @OA\RequestBody(
     *         description="Upload images in request body",
     *         @OA\MediaType(
     *             mediaType="application/octet-stream",
     *             @OA\Schema(
     *                 type="string",
     *                 format="binary"
     *             )
     *         )
     *     )
     *
     * @OA\Parameter(
     *     in="query",
     *     name="bearer",
     *     description="JWT Token"
     * )
     *
     * @OA\Response(response="200", description="OK")
     */
    public function upload(
        Request $request,
        ApiRequestDtoValidator $validator,
        ApiResponseFactory $responseFactory
    )
    {
        $requestDto = UploadProductRequestDto::createFromRequest($request);

        if(null !== $data = $validator->validate($requestDto)){
            return $responseFactory->validationError($data);
        }

        dump($request->getContent());
        
        $file = $requestDto->getFile();
        $file->move($this->getParameter('kernel.project_dir').'/public/uploads', 'products.csv');
        
        $handle = fopen($this->getParameter('kernel.project_dir').'/public/uploads/products.csv', 'r');
        while(($row = fgetcsv($handle)) !== false) {

        }

        return $responseFactory->json();
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get")
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=ProductResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function getById(
        Product $product,
        ApiResponseFactory $responseFactory
    )
    {
        if($product === null){
            return $responseFactory->notFound('Product not found');
        }

        return $responseFactory->json(
            ProductResponseDto::createFromProduct($product)
        );
    }

    /**
     * @Route("/{id}", methods={"POST"}, name="update")
     *
     * @OA\RequestBody(
     *     @Model(type=UpdateProductRequestDto::class)
     * )
     *
     * @OA\Response(
     *     response="200", description="OK", @Model(type=ProductResponseDto::class)
     * )
     *
     * @OA\Response(
     *     response="422", description="Validations"
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function update(
        Request $request,
        ApiRequestDtoValidator $requestDtoValidator,
        ApiResponseFactory $responseFactory,
        UpdateProductCommandHandlerInterface $handler,
        $id
    )
    {
        $requestDto = UpdateProductRequestDto::createFromRequest($request);
        $requestDto->setId($id);

        if(null !== $violations = $requestDtoValidator->validate($requestDto)){
            return $responseFactory->validationError($violations);
        }

        $command = new UpdateProductCommand();
        $requestDto->populateCommand($command);

        $result = $handler->handle($command);

        if($result->hasValidationError()){
            return $responseFactory->validationError($result->getValidationError());
        }

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json(
            ProductResponseDto::createFromProduct($result->getProduct())
        );
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     *
     * @OA\Response(
     *     response="200", description="OK"
     * )
     *
     * @OA\Response(
     *     response="404", description="Not found"
     * )
     */
    public function delete(
        $id, ApiResponseFactory $responseFactory,
        DeleteProductCommandHandlerInterface $handler
    )
    {
        $command = new DeleteProductCommand();
        $command->setId($id);

        $result = $handler->handle($command);

        if($result->isNotFound()){
            return $responseFactory->notFound($result->getNotFoundMessage());
        }

        return $responseFactory->json();
    }
}