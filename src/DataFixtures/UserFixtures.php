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

        $this->createUser('Berni','berni@gmail.com',' ', 'berni123', 'user1', $manager);

        $this->createUser('Ola','Ola@gmail.com', ' ', 'ola123', 'user2', $manager);

        $this->createUser('Jack', 'jack@yahoo.fr', ' ', 'Jack1234', 'user3', $manager);
        
        $this->createUser('Erin', 'erin@gmail.com', ' ','Erin1234', 'user4', $manager);

        $this->createUser('Gabin', 'gabin@gmail.com', ' ','Gabin1234', 'user5', $manager);

        $manager->flush();
    }

    public function createUser($pseudo, $email, $avatar, $password, $reference, ObjectManager $manager){

        $user = New User();

        $user->setPseudo($pseudo);
        $user->setEmail($email);
        $user->setAvatar($avatar);
        $user->setActivated(1);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setValidatedToken(null);

        $manager->persist($user);

        $this->addReference($reference, $user);

        return $user;

    }

}
