<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Picture;

class PictureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createPicture();
        

        $manager->flush();
    }

    public function createPicture($main, $filename, $reference, ObjectManager $manager){

        $picture = new Picture();

        $picture->setMain($main);
        $picture->setFilename($filename);

        

        $manager->persist($picture);

        $this->addReference($reference, $picture);

        return $picture;

    }
}
