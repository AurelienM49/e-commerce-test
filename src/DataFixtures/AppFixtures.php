<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        $faker = Factory::create('fr_FR');

        for($i=0; $i<10; $i++) {
            
            $product = new Product();
            $category = new Category();
            $product->setName($faker->name)
            ->setSlug($faker->slug)
            ->setIllustration($faker->imageUrl(640, 480))
            ->setSubtitle($faker->sentence(6, true))
            ->setDescription($faker->paragraph(3, true))
            ->setPrice($faker->randomFloat(2, 5, 150))
            ->setCategory($category->__toString());

        $manager->persist($product);

        }
        
        $manager->flush();
    }
}
