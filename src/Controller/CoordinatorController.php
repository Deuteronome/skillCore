<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\User;
use App\Form\AddReferentType;
use App\Service\ActivateUserService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/coordination', name: 'app_coordinator_')]
class CoordinatorController extends AbstractController
{
    #[Route('/accueil', name: 'home')]
    public function index(): Response
    {
        $pageTitle = "Gestion des utilisateurs";

        $structure = $this->getUser()->getSite()->getStructure();


        return $this->render('coordinator/index.html.twig', [
            'pageTitle' => $pageTitle,
            'structure' => $structure
        ]);
    }

    #[Route('/ajout_ref/{id}', name: 'add_ref')]
    public function addRef(Site $site, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, ActivateUserService $activateUser):Response
    {
        $pageTitle = "Ajout référent - ". $site->getName();

        $user = new User();
        $user->setSite($site);
        $user->setRoles(["ROLE_REF"]);

        $form = $this->createForm(AddReferentType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $hasher->hashPassword($user, $this->getParameter('app.passwddef'))
            );

            $user->setActive(true);

            $em->persist($user);

            try {
                $em->flush();
                $this->addFlash('success', 'Compte utilisateur créé');
            } catch (Exception $e) {
                $this->addFlash('danger', 'L\'utilisateur n\'a pas pu être créé');
                return $this->redirectToRoute('app_coordinator_add_ref', ['id' => $site->getId()]);
            }

            $activationSuccess = $activateUser->activate($user);

            if(!$activationSuccess) {
                $this->addFlash('danger', 'Le mail d\'activation n\'a pas été envoyé');
            }

            return $this->redirectToRoute('app_coordinator_home');

        }

        return $this->render('coordinator/addRef.html.twig', [
            'pageTitle' => $pageTitle,
            'form' => $form
        ]);
    }
}
