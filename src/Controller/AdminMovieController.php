<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;
use App\Entity\Movie;

class AdminMovieController extends AbstractController
{
    /**
     * @Route("/admin/movie", name="admin_movie")
     */
    public function index(MovieRepository $movieRepository)
    {
        return $this->render('admin_movie/index.html.twig', [
            "movies" => $movieRepository->findAllWithRelations()
        ]);
    }

    /**
     * @Route("/admin/movie/{id}", name="admin_movie_edit")
     */
    public function edit(Movie $movie)
    {
        return $this->render("admin_movie/edit.html.twig", [
            "movie" => $movie
        ]);
    }
}
