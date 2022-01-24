<?php


namespace App\Controller\Api;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test")
     */
    public function test(
        EntityManagerInterface $entityManager
    )
    {
        $entityWithNamespace = 'App\Entity\Customer';
        $fields = $entityManager->getClassMetadata($entityWithNamespace)->getFieldNames();

        $phpTypes = [
            'integer' => 'int',
            'datetime' => '\DateTimeInterface',
            'date' => '\DateTimeInterface',

        ];

        dd($entityManager->getClassMetadata($entityWithNamespace)->fieldMappings);

        foreach($fields as $field){
            dump($phpTypes[$entityManager->getClassMetadata($entityWithNamespace)->getTypeOfField($field)] ?? $entityManager->getClassMetadata($entityWithNamespace)->getTypeOfField($field));
        }

        dd();
    }
}