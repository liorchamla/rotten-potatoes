<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\People;

class PeopleController extends AbstractController
{
    /**
     * @Route("/people/{slug}", name="people_show")
     */
    public function show(People $people)
    {
        return $this->render('people/show.html.twig', [
            'people' => $people
        ]);
    }
}
