<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentTypes extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Cash', 'Credit Card', 'Credit'];

        foreach($types as $type){
            $paymentType = new Payment();
            $paymentType->setName($type);
            $paymentType->setType(strtolower($type));
            if($type === 'Cash'){
                $paymentType->setCanHaveChangeDue(true);
            }else {
                $paymentType->setCanHaveChangeDue(false);
            }
            $paymentType->addStore($this->getReference('store'));

            $manager->persist($paymentType);
        }

        $manager->flush();
    }
}
