<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Movie;

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
    public function showMovie(Movie $movie)
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }
}
