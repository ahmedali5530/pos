<?php

namespace App\EventSubscriber;

use App\Entity\Purchase;
use App\EventSubscriber\Purchase\PurchaseEvent;
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
            $purchaseEvent = new PurchaseEvent();
            $purchaseEvent->entityManager = $this->entityManager;
            $purchaseEvent->onPurchase($result);
        }
    }
}
