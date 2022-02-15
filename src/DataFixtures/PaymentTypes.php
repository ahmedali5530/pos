<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentTypes extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Cash', 'Credit Card', 'Points'];

        foreach($types as $type){
            $paymentType = new Payment();
            $paymentType->setName($type);
            $paymentType->setType(strtolower($type));
            $paymentType->setCanHaveChangeDue(false);

            $manager->persist($paymentType);
        }

        $manager->flush();
    }
}
