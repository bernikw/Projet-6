<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Picture;
use App\DataFixtures\TrickFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createPicture('true', 'trick-1.jpg',  'trick1', $manager);
        $this->createPicture('true', 'trick-2.jpg',  'trick2', $manager);
        $this->createPicture('true', 'trick-3.jpg',  'trick3', $manager);
        $this->createPicture('true', 'trick-4.jpg',  'trick4', $manager);
        $this->createPicture('true', 'trick-5.jpg',  'trick5', $manager);
        $this->createPicture('true', 'trick-6.jpg',  'trick6', $manager);
        $this->createPicture('true', 'trick-7.jpg',  'trick7', $manager);
        $this->createPicture('true', 'trick-8.jpg',  'trick8', $manager);
        $this->createPicture('true', 'trick-9.jpg',  'trick9', $manager);
        $this->createPicture('true', 'trick-10.jpg',  'trick10', $manager);

        $manager->flush();
    }

    public function createPicture($main, $filename, $trick, ObjectManager $manager){

        $picture = new Picture();

        $picture->setMain($main);
        $picture->setFilename($filename);
        $picture->setTrick($this->getReference($trick));  

        $manager->persist($picture);


        return $picture;

    }

    public function getDependencies(): array
    {
        return [ 
            TrickFixtures::class,                    
        ];
    }
}
