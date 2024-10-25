<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referent', name: 'app_referent_')]
class ReferentController extends AbstractController
{
    #[Route('/accueil', name: 'home')]
    public function index(): Response
    {
        $pageTitle = "Tableau de bord";

        return $this->render('standBy.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }

    #[Route('/ajout_stagiaire/{id}', name: 'add_student')]
    function addStudent(User $user, Request $request): Response
    {
        $pageTitle ='Ajout stagiaire - '.$user->getFirstname().' '.$user->getLastname();

        dd($request);

        return $this->render('referent/addStudent.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }
}
