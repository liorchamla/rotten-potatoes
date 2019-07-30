<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\People;
use App\Entity\Rating;

class AppFixtures extends Fixture
{

    private function getRandomPicture(string $gender): string
    {
        $number = mt_rand(1, 90);
        $realGender = ($gender == 'male' ? "men" : "women");
        return "https://randomuser.me/api/portraits/$realGender/$number.jpg";
    }

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

        $people = [];

        $peopleCount = mt_rand(200, 300);

        for ($p = 0; $p < $peopleCount; $p++) {
            $person = new People;
            $gender = $faker->randomElement(['male', 'female']);

            $person->setFirstName($faker->firstName($gender))
                ->setLastName($faker->lastName)
                ->setBirthday($faker->dateTimeBetween("-70 years", "-15 years"))
                ->setPicture($this->getRandomPicture($gender))
                ->setDescription($faker->realText());

            $people[] = $person;

            $manager->persist($person);
        }

        $moviesCount = mt_rand(40, 100);

        for ($m = 0; $m < $moviesCount; $m++) {
            $movie = new Movie;
            $movie->setTitle($faker->catchPhrase)
                ->setPoster($faker->imageUrl(200, 500, null, false))
                ->setReleaseAt($faker->dateTimeBetween('-40 years'))
                ->setSynopsis($faker->realText());

            $director = $faker->randomElement($people);
            $actors = $faker->randomElements($people, mt_rand(3, 8));

            $movie->setDirector($director);

            foreach ($actors as $actor) {
                $movie->addActor($actor);
            }

            $randomCategories = $faker->randomElements($categories, mt_rand(1, 3));

            foreach ($randomCategories as $category) {
                $movie->addCategory($category);
            }

            /**
             * RATINGS D'UN FILM
             */
            $ratingsCount = mt_rand(5, 10);
            for ($r = 0; $r < $ratingsCount; $r++) {
                $rating = new Rating;
                $rating->setComment($faker->realText())
                    ->setCreatedAt($faker->dateTimeBetween("-6 months"))
                    ->setNotation(mt_rand(1, 5))
                    ->setMovie($movie);

                $manager->persist($rating);
            }

            $manager->persist($movie);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
