<?php


namespace App\Controller\Api\Admin;

use App\Core\Dto\Controller\Api\Admin\Setting\SettingListResponseDto;
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
        ApiResponseFactory     $responseFactory,
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
     * @OA\Parameter(
     *   name="type",
     *   in="query",
     *   description="Search in type"
     * )
     *
     * @OA\Response(
     *     @Model(type=SettingListResponseDto::class), response="200", description="OK"
     * )
     */
    public function getSetting(
        Request $request, ApiResponseFactory $responseFactory, EntityManagerInterface $entityManager
    )
    {
        $settings = $entityManager->getRepository(Setting::class)->findBy([
            'type' => $request->query->get('type')
        ]);

        $list = SettingListResponseDto::createFromList($settings);

        return $responseFactory->json($list);
    }
}
