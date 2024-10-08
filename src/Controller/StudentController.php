<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student', name: 'app_student_')]
class StudentController extends AbstractController
{
    #[Route('/accueil', name:'home')]
    public function index(): Response
    {
        $pageTitle = "Tableau de bord";

        return $this->render('standBy.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }
}
