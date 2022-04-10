<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Video;
use App\DataFixtures\TrickFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createVideo('https://youtu.be/V9xuy-rVj9w', 'trick1', $manager);
        $this->createVideo('https://youtu.be/6vA4BuJM3_g', 'trick2', $manager);
        $this->createVideo('https://youtu.be/_OMar04NRZw', 'trick3', $manager);
        $this->createVideo('https://youtu.be/9LQkQXMuuUc', 'trick4', $manager);
        $this->createVideo('https://youtu.be/DO0Xfada_xw', 'trick5', $manager);
        $this->createVideo('https://youtu.be/-vyWHLblti0', 'trick6', $manager);
        $this->createVideo('https://youtu.be/sVUnwWhz1x0', 'trick7', $manager);
        $this->createVideo('https://youtu.be/qsd8uaex-Is', 'trick8', $manager);
        $this->createVideo('https://youtu.be/_8TBfD5VPnM', 'trick9', $manager);
        $this->createVideo('https://youtu.be/Dgss7b9quAE', 'trick10', $manager);
   
        $manager->flush();
    }


    public function createVideo($url, $trick, ObjectManager $manager){

        $video = new Video();

         $video->setUrl($url);
         $video->setTrick($this->getReference($trick));

         $manager->persist($video);


         return $video;
        
    }

    public function getDependencies(): array
    {
        return [ 
            TrickFixtures::class,                     
        ];
    }



}
