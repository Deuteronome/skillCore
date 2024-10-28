<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stagiaire', name: 'app_student_')]
class StudentController extends AbstractController
{
    #[Route('/accueil', name:'home')]
    public function index(): Response
    {
        $pageTitle = "Tableau de bord - ".$this->getUser()->getFirstname()." ".$this->getUser()->getLastname();

        return $this->render('student/index.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }

    #[Route('/competences', name:'skill_map')]
    public function skillMap():Response
    {
        $pageTitle = "Carte de compétences - ".$this->getUser()->getFirstname()." ".$this->getUser()->getLastname();
        return $this->render('student/skillMap.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }
}
