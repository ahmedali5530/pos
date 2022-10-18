<?php


namespace App\Core\Entity\EntityManager;


use App\Core\Entity\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class EntityManager extends EntityRepository
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->em = $entityManager;
    }

    abstract protected function getEntityClass(): string;

    public function persist($object)
    {
        $this->em->persist($object);
    }

    public function persistAll(iterable $objects)
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

    public function removeAll(iterable $objects)
    {
        foreach($objects as $object){
            $this->em->remove($object);
        }

        $this->flush();
    }

    public function save($object){
        $this->persist($object);
        $this->flush();
    }

    public function saveAll(iterable $objects){
        foreach($objects as $object){
            $this->em->persist($object);
        }

        $this->flush();
    }
}
