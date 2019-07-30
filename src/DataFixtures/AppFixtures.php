<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Category;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categories = [];

        $categoriesTitles = ['Horreur', 'Comédie', 'Science Fiction', 'Histoire', 'Action', 'Aventure', 'Animation'];

        foreach ($categoriesTitles as $title) {
            $category = new Category;
            $category->setTitle($title);

            $manager->persist($category);

            $categories[] = $category;
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
