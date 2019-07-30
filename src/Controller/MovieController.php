<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class MovieController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="movie_category")
     */
    public function category(Category $category)
    {
        return $this->render('movie/category.html.twig', [
            'category' => $category
        ]);
    }
}
