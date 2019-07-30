<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;
use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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
    public function edit(Movie $movie, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute("admin_movie");
        }

        return $this->render("admin_movie/edit.html.twig", [
            "movie" => $movie,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/movie/{id}/delete", name="admin_movie_delete")
     */
    public function delete(Movie $movie, ObjectManager $manager)
    {
        $manager->remove($movie);
        $manager->flush();

        return $this->redirectToRoute("admin_movie");
    }
}
