<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger) {}


    public function load(ObjectManager $manager): void
    {

        $admin = new User();
        $admin->setEmail('berni@gmail.com');
        $admin->setPseudo('Berni');
        $admin->setAvatar('');
        $admin->setActivated(true);
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'berni123'));
        $admin->setRoles(['ROLE_USER']);
        $admin->setValidatedToken(22020289675764);

        $manager->persist($admin);

        $user = new User();
        $user->setEmail('Ola@gmail.com');
        $user->setPseudo('Ola');
        $user->setAvatar('');
        $user->setActivated(false);
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'ola123'));
        $user->setRoles(['ROLE_USER']);
        $user->setValidatedToken(1111113131090131);

        $manager->persist($user);

        $manager->flush();
    }

}
