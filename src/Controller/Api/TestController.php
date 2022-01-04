<?php


namespace App\Controller\Api;


use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @Route("/test")
     */
    public function test()
    {
        $list = array_is_list([
            1, 2, 3
        ]);

        dd($list);
    }
}