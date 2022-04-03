<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryDatas = ["grab", "rotation"];
        $categorySave = [];
        foreach($categoryDatas as $categoryData){
            $category = new Category();

            $category->setName($categoryData);
            $category->setDescription($categoryData);
            
            $manager->persist($category);
            $categorySave[] = $category;
        }
        // $product = new Product();
        

        $manager->flush();
    }
}
