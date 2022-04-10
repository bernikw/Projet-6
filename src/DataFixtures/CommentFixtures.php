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
        $this->createComment('Extra trick', 'user2', 'trick1', $manager);
        $this->createComment('Fantastique', 'user3', 'trick2', $manager);
        $this->createComment('Genial', 'user4', 'trick3', $manager);
        $this->createComment('Extraordinaire', 'user5', 'trick4', $manager);
        $this->createComment('Incroyable', 'user1', 'trick5', $manager);
        $this->createComment('Superbe', 'user2', 'trick6', $manager);
        $this->createComment('Sans faute', 'user3', 'trick7', $manager);
        $this->createComment('Très bien', 'user4', 'trick8', $manager);
        $this->createComment('Bon courage', 'user5', 'trick9', $manager);
        $this->createComment('C\'est genial', 'user3', 'trick10', $manager);

        $manager->flush();
    }

    public function createComment($message, $user, $trick, ObjectManager $manager){

        $comment = new Comment();

        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setMessage($message);
        $comment->setUser($this->getReference($user));
        $comment->setTrick($this->getReference($trick));

        $manager->persist($comment);


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
