<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RatingRepository;
use App\Entity\Rating;
use Doctrine\Common\Persistence\ObjectManager;

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

    /**
     * @Route("/admin/rating/{id}/delete", name="admin_rating_delete")
     */
    public function delete(Rating $rating, ObjectManager $manager)
    {
        $manager->remove($rating);
        $manager->flush();

        return $this->redirectToRoute("admin_rating");
    }
}
