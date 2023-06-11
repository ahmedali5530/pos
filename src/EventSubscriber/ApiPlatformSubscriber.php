<?php

namespace App\EventSubscriber;

use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Symfony\EventListener\EventPriorities;

class ApiPlatformSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['onPostWrite', EventPriorities::POST_WRITE]
            ]
        ];
    }

    public function onPostWrite(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        if($result instanceof Purchase){
            if($result->getPurchaseOrder() !== null){
                $result->getPurchaseOrder()->setIsUsed(true);
            }

            foreach($result->getItems() as $item){
                if($result->getUpdatePrice()){
                    $item->getItem()->setCost($item->getPurchasePrice()); // update product cost

                    foreach($item->getVariants() as $variant){
                        $variant->getVariant()->setPrice($variant->getPurchasePrice()); // update variant price
                    }
                }
                if($result->getUpdateStocks()){
                    $item->getItem()->setQuantity($item->getQuantity()); // update product quantity

                    foreach($item->getVariants() as $variant){
                        $variant->getVariant()->setQuantity($variant->getQuantity()); // update variant quantity
                    }
                }
            }

            $this->entityManager->persist($result);
        }

        $this->entityManager->flush();
    }
}
