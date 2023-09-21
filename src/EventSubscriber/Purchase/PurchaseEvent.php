<?php

namespace App\EventSubscriber\Purchase;

use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseEvent
{
    public EntityManagerInterface $entityManager;

    /**
     * @throws \Exception
     */
    public function onPurchase(Purchase $purchase)
    {
        if(!$this->entityManager instanceof EntityManagerInterface){
            throw new \Exception('Please pass an entity manager instance');
        }

        if($purchase->getPurchaseOrder() !== null){
            $purchase->getPurchaseOrder()->setIsUsed(true);
        }

        foreach($purchase->getItems() as $item){
            if($purchase->getUpdatePrice()){
                $item->getItem()->setCost($item->getPurchasePrice()); // update product cost

                foreach($item->getVariants() as $variant){
                    $variant->getVariant()->setPrice($variant->getPurchasePrice()); // update variant price
                }
            }
            if($purchase->getUpdateStocks()){
                // get store and update in it
                $store = null;
                foreach($item->getItem()->getStores() as $s){
                    if($s->getStore()->getId() === $purchase->getStore()->getId()){
                        $store = $s;
                        break;
                    }
                }
                if($store !== null){
                    $store->setQuantity($store->getQuantity() + $item->getQuantity());
                }

                $this->entityManager->persist($store);

                foreach($item->getVariants() as $variant){
                    $variant->getVariant()->setQuantity($variant->getQuantity()); // update variant quantity
                }
            }
        }

        $this->entityManager->persist($purchase);
        $this->entityManager->flush();
    }
}
