<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RatingRepository;

class AdminRatingController extends AbstractController
{
    /**
     * @Route("/admin/rating", name="admin_rating")
     */
    public function index(RatingRepository $ratingRepository)
    {
        return $this->render('admin_rating/index.html.twig', [
            'ratings' => $ratingRepository->findAllWithRelations()
        ]);
    }
}
