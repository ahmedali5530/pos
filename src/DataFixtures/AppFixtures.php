<?php

namespace App\DataFixtures;

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

        $manager->persist($user);
        $manager->flush();
    }
}
