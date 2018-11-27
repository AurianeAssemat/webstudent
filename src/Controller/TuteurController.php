<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TuteurController extends AbstractController
{
    /**
     * @Route("/tuteur", name="tuteur")
     */
    public function index()
    {
        return $this->render('tuteur/index.html.twig', [
            'controller_name' => 'TuteurController',
        ]);
    }
}
