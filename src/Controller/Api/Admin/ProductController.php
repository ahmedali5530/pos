<?php


namespace App\Controller\Api\Admin;


use App\Core\Dto\Controller\Api\Admin\Product\CreateProductRequestDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductListKeywordsResponseDto;
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
use App\Core\Product\Query\GetProductsKeywords\GetProductsKeywordsQuery;
use App\Core\Product\Query\GetProductsKeywords\GetProductsKeywordsQueryHandlerInterface;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQuery;
use App\Core\Product\Query\GetProductsListQuery\GetProductsListQueryHandlerInterface;
use App\Core\Validation\ApiRequestDtoValidator;
use App\Entity\Product;
use App\Factory\Controller\ApiResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ProductController
 * @package App\Controller\Api\Admin
 * @Route("/admin/product", name="admin_products_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/keywords", methods={"GET"}, name="keywords")
     */
    public function keywords(
        Request $request,
        ApiResponseFactory $responseFactory,
        GetProductsKeywordsQueryHandlerInterface $productsListQueryHandler,
        SerializerInterface $serializer
    )
    {
        $requestDto = ProductListRequestDto::createFromRequest($request);

        $query = new GetProductsKeywordsQuery();

        $requestDto->populateQuery($query);

        $list = $productsListQueryHandler->handle($query);

        $result = $serializer->serialize($list->getList(), 'jsonld', [
            'groups' => ['keyword', 'uuid.read', 'time.read']
        ]);

        return $this->json([
            'list' => json_decode($result)
        ]);
    }

    /**
     * @Route("/quantities", methods={"GET"}, name="quantities")
     */
    public function getQuantity(
        Request $request,
        ApiResponseFactory $responseFactory,
        GetProductsKeywordsQueryHandlerInterface $productsListQueryHandler,
        SerializerInterface $serializer
    ){
        $requestDto = ProductListRequestDto::createFromRequest($request);

        $query = new GetProductsKeywordsQuery();

        $requestDto->populateQuery($query);

        $list = $productsListQueryHandler->handle($query);

        $quantity = null;
        foreach($list->getList() as $item){
            if($requestDto->getVariantId() !== null){
                foreach($item->getVariants() as $variant){
                    if((int) $requestDto->getVariantId() === $variant->getId()){
                        $quantity = $variant->getQuantity();
                        break 2;
                    }
                }
            }
            foreach($item->getStores() as $store){
                if($store->getStore()->getId() === (int) $requestDto->getStore()){
                    $quantity = $store->getQuantity();
                    break 2;
                }
            }
        }

        return $this->json([
            'quantity' => $quantity
        ]);
    }

    /**
     * @Route("/export", name="download_products", methods={"GET"})
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
            'ID', 'Name', 'Barcode', 'Is Available?',
            'Purchase price', 'Sale price', 'Available Quantity', 'Purchase Unit', 'Sale Unit'
        ];
        fputcsv($handle, $columns);
        /** @var Product $item */
        foreach($list->getList() as $item){
            fputcsv($handle, [
                $item->getId(), $item->getName(), $item->getBarcode(), $item->getIsAvailable(),
                $item->getCost(), $item->getBasePrice(),
                $item->getQuantity(), $item->getPurchaseUnit(), $item->getSaleUnit()
            ]);
        }

        return $responseFactory->download($fileName);
    }

    /**
     * @Route("/import", name="import_products", methods={"POST"})
     */
    public function upload(
        Request $request,
        ApiRequestDtoValidator $validator,
        ApiResponseFactory $responseFactory,
        CreateProductCommandHandlerInterface $createProductCommandHandler,
        UpdateProductCommandHandlerInterface $updateProductCommandHandler
    )
    {
        $requestDto = UploadProductRequestDto::createFromRequest($request);

        if(null !== $data = $validator->validate($requestDto)){
            return $responseFactory->validationError($data);
        }

        $file = $requestDto->getFile();
        $file->move($this->getParameter('kernel.project_dir').'/public/uploads', 'products.csv');

        $handle = fopen($this->getParameter('kernel.project_dir').'/public/uploads/products.csv', 'r');
        $index = 0;
        $errors = [];
        while(($row = fgetcsv($handle)) !== false) {
            if($index === 0){
                //skip header
                $index++;
                continue;
            }

            if((int)$row[0] === 0 || trim($row[0]) === ''){
                //create product
                $command = new CreateProductCommand();
                $command->setName($row[1]);
                $command->setBarcode($row[2]);
                $command->setIsAvailable($row[3]);
                $command->setBasePrice((float)$row[4]);
                $command->setCost((float)$row[5]);
                $command->setQuantity((float)$row[6]);
                $command->setPurchaseUnit($row[7]);
                $command->setSaleUnit($row[8]);

                $result = $createProductCommandHandler->handle($command);

                if($result->hasValidationError()){
                    $errors[$index] = $result->getValidationError();
                }

                if($result->isNotFound()){
                    $errors[$index] = $result->getValidationError();
                }
            }else{
                //update product
                $command = new UpdateProductCommand();

                $command->setId((int)$row[0]);
                $command->setName($row[1]);
                $command->setBarcode($row[2]);
                $command->setIsAvailable($row[3]);
                $command->setBasePrice((float)$row[4]);
                $command->setCost((float)$row[5]);
                $command->setQuantity((float)$row[6]);
                $command->setPurchaseUnit($row[7]);
                $command->setSaleUnit($row[8]);


                $result = $updateProductCommandHandler->handle($command);

                if($result->hasValidationError()){
                    $errors[$index] = $result->getValidationError();
                }

                if($result->isNotFound()){
                    $errors[$index] = $result->getValidationError();
                }
            }

            $index++;
        }

        if(count($errors) > 0){
            return $responseFactory->validationError($errors);
        }

        return $responseFactory->json(true);
    }
}
