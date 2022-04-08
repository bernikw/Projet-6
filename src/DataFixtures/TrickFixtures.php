<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {

        $this->createTrick('Mute', 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant', 'user1','category1', 'trick1', $manager);

        $this->createTrick('Indy', 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière', 'user1', 'category1', 'trick2', $manager);


        $manager->flush();
    }
    public function createTrick($name, $content, $user, $category, $reference, ObjectManager $manager){

        $trick = new Trick();
        $trick->setName($name);
        $trick->setCreatedAt(new \DateTimeImmutable());
        $trick->setContent($content);
        $trick->setSlug($this->slugger->slug($trick->getName())->lower());

        $trick->setUser($this->getReference($user));
        $trick->setCategory($this->getReference($category));


        $manager->persist($trick);

        $this->addReference($reference, $trick);

        return $trick;

    }

    public function getDependencies(): array
    {
        return [ 
            CategoryFixtures::class,
            UserFixtures::class,
            VideoFixtures::class,
            PictureFixtures::class,
            CommentFixtures::class           
        ];
    }

}
