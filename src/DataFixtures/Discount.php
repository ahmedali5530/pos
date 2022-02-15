<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Discount extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = [5, 20, 50, 100];

        foreach($types as $type){
            $discount = new \App\Entity\Discount();
            $discount->setName('Discount '.$type);
            $discount->setRate($type);
            $discount->setRateType(\App\Entity\Discount::RATE_PERCENT);
            $discount->setScope(\App\Entity\Discount::SCOPE_EXACT);
            $manager->persist($discount);
        }

        $discount = new \App\Entity\Discount();
        $discount->setName('Fixed 100');
        $discount->setScope(\App\Entity\Discount::SCOPE_EXACT);
        $discount->setRate(100);
        $discount->setRateType(\App\Entity\Discount::RATE_FIXED);
        $manager->persist($discount);

        $discount = new \App\Entity\Discount();
        $discount->setName('Open');
        $discount->setScope(\App\Entity\Discount::SCOPE_OPEN);
        $manager->persist($discount);

        $manager->flush();
    }
}
