<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/coordinator', name: 'app_coordinator_')]
class CoordinatorController extends AbstractController
{
    #[Route('/accueil', name: 'home')]
    public function index(): Response
    {
        $pageTitle = "Tableau de bord";

        return $this->render('standBy.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }
}
