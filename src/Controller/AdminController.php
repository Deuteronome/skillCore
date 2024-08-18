<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/accueil', name: 'home')]
    public function index(): Response
    {
        $pageTitle = "Tableau de bord";
        
        return $this->render('admin/home.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }
}
