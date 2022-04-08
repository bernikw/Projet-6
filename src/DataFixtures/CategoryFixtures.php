<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger){}


    public function load(ObjectManager $manager): void
    {
       /* $categoryDatas = ["grab", "rotation", "flip", "slide", "old school"];
        $categorySave = [];
        foreach($categoryDatas as $categoryData){
            $category = new Category();

            $category->setName($categoryData);
            $category->setDescription($categoryData);
            $category->setSlug($this->slugger->slug($category->getName()));

            $manager->persist($category);
            $categorySave[] = $category;
        } */

        $this->createCategory("grab", 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »', 'category1', $manager );
        $this->createCategory('rotation', 'On désigne par le mot « rotation » uniquement des rotations horizontales ; les rotations verticales sont des flips.', 'category2', $manager);

        $this->createCategory('flip', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.', 'category3', $manager);

        $this->createCategory('slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.', 'category4', $manager);

        $this->createCategory('old school', 'Le terme old school désigne un style de freestyle caractérisée par en ensemble de figure et une manière de réaliser des figures passée de mode, qui fait penser au freestyle des années 1980 - début 1990 ', 'category5', $manager);

        $manager->flush();
    }

    public function createCategory($name, $description, $reference, ObjectManager $manager){

        $category = new Category();

            $category->setName($name);
            $category->setDescription($description);
            $category->setSlug($this->slugger->slug($category->getName()));

            $manager->persist($category);

            $this->addReference($reference, $category);
            
            return $category;

    }
}
