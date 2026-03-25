<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN = 'USER_ADMIN';

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('admin@demo.fr');
        $user->setUsername('admin');
        $user->setIsVerified(true);
        $user->setApiToken('admin_token');
        $user->setPassword($this->hasher->hashPassword($user, 'admin'));
        $this->addReference(self::ADMIN, $user);
        $manager->persist($user);
    
        for ($i=1; $i <= 10; $i++) { 
            $user = new User();
            $user->setRoles(['ROLE_USER']);
            $user->setEmail("user{$i}@demo.fr");
            $user->setUsername("user{$i}");
            $user->setIsVerified(true);
            $user->setApiToken("user{$i}");
            $user->setPassword($this->hasher->hashPassword($user, "password"));
            $this->addReference("USER{$i}", $user);
            $manager->persist($user);
            
        }
        $manager->flush();    
    }
}
