<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MovieRepository $movieRepository)
    {
        return $this->render('home/index.html.twig', [
            'lastReleased' => $movieRepository->findLastReleasedMovies(),
            'bestMovies' => $movieRepository->findBestMoviesByAvgRatings(),
            'worstMovies' => $movieRepository->findWorstMoviesByAvgRatings()
        ]);
    }
}
