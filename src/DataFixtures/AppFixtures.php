<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\People;
use App\Entity\Rating;
use App\Entity\User;
use Faker\Factory;

/**
 * Fixtures pour le projet Rotten Potatoes
 */
class AppFixtures extends Fixture
{
    /**
     * On aura besoin de l'encoder pour les passwords des utilisateurs
     * 
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * On se fait injecter l'encodeur :-)
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Retourne une URL random pour un avatar en fonction du genre demandé
     *
     * @param string $gender
     * @return string
     */
    protected function getRandomPicture(string $gender): string
    {
        $number = mt_rand(1, 90);

        if ($gender != "men" && $gender != "women") {
            $realGender = ($gender == 'male' ? "men" : "women");
        } else {
            $realGender = $gender;
        }

        return "https://randomuser.me/api/portraits/$realGender/$number.jpg";
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        /**
         * LES CATEGORIES DE FILMS :
         */
        $categories = [];

        // Un tableau de titres de catégories
        $categoriesTitles = ['Horreur', 'Comédie', 'Science Fiction', 'Histoire', 'Action', 'Aventure', 'Animation'];

        // Pour chaque titre de catégorie je créé une Category
        foreach ($categoriesTitles as $title) {
            $category = new Category;
            $category->setTitle($title);

            $manager->persist($category);

            // J'ajoute chaque catégorie au tableau des catégories pour m'en resservir plus tard
            $categories[] = $category;
        }

        /**
         * LES PEOPLES (ACTEURS / REALISATEURS)
         */
        $people = [];

        $peopleCount = mt_rand(200, 300);

        for ($p = 0; $p < $peopleCount; $p++) {
            $person = new People;

            // Je choisi un genre au hasard entre male et female
            $gender = $faker->randomElement(['male', 'female']);

            $person->setFirstName($faker->firstName($gender))
                ->setLastName($faker->lastName)
                ->setBirthday($faker->dateTimeBetween("-70 years", "-15 years"))
                ->setPicture($this->getRandomPicture($gender))
                ->setDescription($faker->realText());

            // J'ajoute la personne au tableau des people pour m'en resservir après
            $people[] = $person;

            $manager->persist($person);
        }

        /**
         * LES UTILISATEURS
         */
        $usersCount = mt_rand(20, 40);
        $users = [];

        for ($u = 0; $u < $usersCount; $u++) {
            $user = new User;
            $gender = $faker->randomElement(['men', 'women']);
            $user->setAvatar($this->getRandomPicture($gender))
                ->setEmail("user$u@gmail.com")
                ->setPassword($this->encoder->encodePassword($user, "pass"))
                ->setName($faker->userName);

            $manager->persist($user);

            // J'ajoute l'utilisateur au tableau pour m'en resservir après
            $users[] = $user;
        }

        /**
         * LES FILMS (MOVIES)
         */
        $moviesCount = mt_rand(40, 100);

        for ($m = 0; $m < $moviesCount; $m++) {
            $movie = new Movie;
            $movie->setTitle($faker->catchPhrase)
                ->setPoster($faker->imageUrl(200, 500, null, false))
                ->setReleasedAt($faker->dateTimeBetween('-40 years'))
                ->setSynopsis($faker->realText());

            // Je prend un people au hasard qui sera le réalisateur
            $director = $faker->randomElement($people);
            $movie->setDirector($director);

            // Je prend des peoples au hasard qui seront les acteurs
            $actors = $faker->randomElements($people, mt_rand(3, 8));
            foreach ($actors as $actor) {
                $movie->addActor($actor);
            }

            // Je prend des catégories au hasard qui seront les catégories du film
            $randomCategories = $faker->randomElements($categories, mt_rand(1, 3));
            foreach ($randomCategories as $category) {
                $movie->addCategory($category);
            }

            /**
             * LES RATINGS D'UN FILM
             */
            $ratingsCount = mt_rand(5, 10);
            for ($r = 0; $r < $ratingsCount; $r++) {
                $rating = new Rating;
                $rating->setComment($faker->realText())
                    ->setCreatedAt($faker->dateTimeBetween("-6 months"))
                    ->setNotation(mt_rand(1, 5))
                    ->setMovie($movie)
                    // Je prend un utilisateur au hasard qui aura posté ce commentaire
                    ->setAuthor($faker->randomElement($users));

                $manager->persist($rating);
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }
}
