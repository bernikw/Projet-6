<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createComment($manager);

        $manager->flush();
    }

    public function createComment($message, $reference, ObjectManager $manager){

        $comment = new Comment();

        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setMessage($message);

        

        $manager->persist($comment);

        $this->addReference($reference, $comment);

        return $comment;
    }

    public function getDependencies(): array
    {
        return [ 
            UserFixtures::class,
            TrickFixtures::class          
        ];
    }
}
