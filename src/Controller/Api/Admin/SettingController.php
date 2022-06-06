<?php


namespace App\Controller\Api\Admin;

use App\Core\Dto\Common\Setting\SettingDto;
use App\Core\Dto\Controller\Api\Admin\Product\CreateProductRequestDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductListRequestDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductListResponseDto;
use App\Core\Dto\Controller\Api\Admin\Product\ProductResponseDto;
use App\Core\Dto\Controller\Api\Admin\Product\UpdateProductRequestDto;
use App\Core\Dto\Controller\Api\Admin\Setting\SettingListResponseDto;
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
use App\Entity\Setting;
use App\Factory\Controller\ApiResponseFactory;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller\Api\Admin
 * @Route("/admin/setting", name="admin_settings_")
 * @OA\Tag(name="Admin")
 */
class SettingController extends AbstractController
{
    /**
     * @Route("/list", methods={"GET"}, name="list")
     *
     * @OA\Response(
     *     @Model(type=SettingListResponseDto::class), response="200", description="OK"
     * )
     */
    public function getSettings(
        ApiResponseFactory $responseFactory,
        EntityManagerInterface $entityManager
    )
    {
        $settings = $entityManager->getRepository(Setting::class)->findBy([]);

        $response = SettingListResponseDto::createFromList($settings);

        return $responseFactory->json($response);
    }


    /**
     * @Route("/get", methods={"GET"}, name="get_item")
     *
     * @OA\Response(
     *     @Model(type=SettingDto::class), response="200", description="OK"
     * )
     */
    public function getSetting(

    )
    {

    }
}