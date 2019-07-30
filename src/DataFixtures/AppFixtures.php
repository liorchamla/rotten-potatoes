<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Category;
use App\Entity\Movie;

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

        $moviesCount = mt_rand(40, 100);
        for ($m = 0; $m < $moviesCount; $m++) {
            $movie = new Movie;
            $movie->setTitle($faker->catchPhrase)
                ->setPoster($faker->imageUrl(200, 500, null, false))
                ->setReleaseAt($faker->dateTimeBetween('-40 years'))
                ->setSynopsis($faker->realText());

            $randomCategories = $faker->randomElements($categories, mt_rand(1, 3));

            foreach ($randomCategories as $category) {
                $movie->addCategory($category);
            }

            $manager->persist($movie);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
