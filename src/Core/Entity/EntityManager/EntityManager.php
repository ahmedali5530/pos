<?php


namespace App\Core\Entity\EntityManager;


use Doctrine\ORM\EntityManagerInterface;

abstract class EntityManager
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    abstract protected function getEntityClass(): string;

    public function persist($object)
    {
        $this->em->persist($object);
    }

    public function persistAll(array $objects)
    {
        foreach($objects as $object){
            $this->em->persist($object);
        }
    }

    public function flush()
    {
        $this->em->flush();
    }

    public function remove($object)
    {
        $this->em->remove($object);
    }

    public function removeAll(array $objects)
    {
        foreach($objects as $object){
            $this->em->remove($object);
        }
    }
}