<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Video;

class VideoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createVideo('https://youtu.be/V9xuy-rVj9w', 'video1', $manager);

        $this->createVideo();

        $manager->flush();
    }


    public function createVideo($url, $reference,ObjectManager $manager){

        $video = new Video();

         $video->setUrl($url);


         $manager->persist($video);

         $this->addReference($reference, $video);

         return $video;
        
    }


}
