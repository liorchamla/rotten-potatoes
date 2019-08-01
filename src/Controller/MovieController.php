<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Movie;
use App\Repository\CategoryRepository;
use App\Entity\Rating;
use App\Form\RatingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\RatingRepository;
use App\Repository\MovieRepository;
use App\Entity\Like;

class MovieController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="movie_category")
     */
    public function showCategory(Category $category)
    {
        return $this->render('movie/category.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/movie/{slug}", name="movie_show")
     */
    public function showMovie(Movie $movie, Request $request, ObjectManager $manager, RatingRepository $ratingRepository)
    {

        $rating = new Rating();

        $form = $this->createForm(RatingType::class, $rating);

        $alreadyHasRating = (null != $ratingRepository->findOneBy(["movie" => $movie, "author" => $this->getUser()]));

        if (!$alreadyHasRating) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $rating->setAuthor($this->getUser())
                    ->setMovie($movie)
                    ->setCreatedAt(new \DateTime());

                $manager->persist($rating);
                $manager->flush();

                $this->redirectToRoute("movie_show", ["slug" => $movie->getSlug()]);
            }
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
            'alreadyHasRating' => $alreadyHasRating
        ]);
    }

    /**
     * @Route("/search", name="movie_search")
     */
    public function search(MovieRepository $movieRepository, Request $request)
    {
        $search = $request->query->get('q', '');

        $results = $movieRepository->findBySearch($search);

        return $this->render('movie/search.html.twig', [
            'results' => $results,
            'search' => $search
        ]);
    }

    /**
     * @Route("/rating/{id}/like", name="movie_rating_like")
     */
    public function ratingLike(Rating $rating, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $this->persistLike($rating, true);

        return $this->getJsonResponseForRatingLikes($rating);
    }

    /**
     * @Route("/rating/{id}/dislike", name="movie_rating_dislike")
     */
    public function ratingDislike(Rating $rating, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $this->persistLike($rating, false);

        return $this->getJsonResponseForRatingLikes($rating);
    }

    public function menuCategories(CategoryRepository $repo)
    {
        $categories = $repo->findAll();

        return $this->render('movie/_categories.html.twig', ['categories' => $categories]);
    }

    protected function getJsonResponseForRatingLikes(Rating $rating)
    {
        return $this->json(['positiveLikes' => $rating->getPositiveLikes()->count(), 'negativeLikes' => $rating->getNegativeLikes()->count()]);
    }

    protected function persistLike(Rating $rating, bool $isPositive = true)
    {
        if (!$rating->hasLikeFromUser($this->getUser())) {
            $like = new Like;
            $like->setRating($rating)
                ->setAuthor($this->getUser())
                ->setPositive($isPositive);

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($like);
            $manager->flush();

            $manager->refresh($rating);
        }
    }
}
