<?php

namespace App\DataFixtures;

use App\Entity\Store;
use App\Entity\Terminal;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setIsActive(true);
        $user->setUsername('admin');
        $user->setDisplayName('Admin');
        $user->setRoles(['ROLE_USER']);
        $user->setSalt(Uuid::uuid4());
        $user->setPassword($this->hasher->hashPassword($user, 'admin'));
        $user->setEmail('admin@gmail.com');

        //create store
        $store = new Store();
        $store->setName('Main');
        $manager->persist($store);

        $this->addReference('store', $store);

        //create terminal
        $terminal = new Terminal();
        $terminal->setCode('A1');
        $terminal->setStore($store);

        $manager->persist($terminal);

        //add store
        $user->addStore($store);
        $manager->persist($user);

        $manager->flush();
    }
}
