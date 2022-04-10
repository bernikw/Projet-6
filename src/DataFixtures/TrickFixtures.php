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

        $this->createTrick('Un slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.', 'user2', 'category4', 'trick3', $manager);

        $this->createTrick('Figures désuètes', 'Japan air - saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside', 'user3', 'category5', 'trick4', $manager);

        $this->createTrick('Tail grab', 'Saisie de la partie arrière de la planche, avec la main arrière', 'user4', 'category1', 'trick5', $manager);

        $this->createTrick('Un flip', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière. Il est possible de faire plusieurs flips à la suite, et d\'ajouter un grab à la rotation.', 'user5', 'category3', 'trick6', $manager);

        $this->createTrick('Un 180', 'Un 180 désigne un demi-tour, soit 180 degrés d\'angle', 'user3', 'category2', 'trick7', $manager);

        $this->createTrick('Seat belt', 'Saisie du carre frontside à l\'arrière avec la main avant', 'user2', 'category1', 'trick8', $manager);

        $this->createTrick('Truck driver', 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)', 'user3', 'category1', 'trick9', $manager);

        $this->createTrick('Nose grab', 'Saisie de la partie avant de la planche, avec la main avant', 'user3', 'category1', 'trick10', $manager);


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
        ];
    }

}
