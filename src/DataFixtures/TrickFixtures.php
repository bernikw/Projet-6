<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\DataFixtures\UserFixtures;



class TrickFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {

        $trick = new Trick();

        $trick->setName('Mute');
        $trick->setCreatedAt(new \DateTimeImmutable());
        $trick->setUpdatedAt(new \DateTimeImmutable());
        $trick->setContent('Saisie de la carre frontside de la planche entre les deux pieds avec la main avant');
        $trick->setSlug($this->slugger->slug($trick->getName())->lower());
        $trick->setUser($user);


        $manager->persist($trick);

        $manager->flush();
    }
}
