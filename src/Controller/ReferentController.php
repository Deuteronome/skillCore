<?php

namespace App\Controller;

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
    function addStudent(User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, ActivateUserService $activateUser): Response
    {
        $pageTitle ='Ajout stagiaire - '.$user->getFirstname().' '.$user->getLastname();

        $student=new User();

        $student->setReferent($user);
        $student->setSite($user->getSite());

        $form = $this->createForm(AddReferentType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $student->setPassword(
                $hasher->hashPassword($student, $this->getParameter('app.passwddef'))
            );

            $student->setActive(true);
            //$user->setRoles(["ROLE_USER"]); 

            $em->persist($student);

            try {
                $em->flush();
                $this->addFlash('success', 'Compte stagiaire créé');
            } catch (Exception $e) {
                $this->addFlash('danger', 'L\'utilisateur n\'a pas pu être créé :'.$e->getMessage());
                return $this->redirectToRoute('app_referent_add_student', ['id' => $user->getId()]);
            }

            $activationSuccess = $activateUser->activate($student);

            if(!$activationSuccess) {
                $this->addFlash('danger', 'Le mail d\'activation n\'a pas été envoyé');
            }

            $trackerSuccess = $activateUser->studentTracker($student);
            
            if(!$trackerSuccess) {
                $this->addFlash('danger', 'Les compétences du stagaire n\ont pas été correctement initialisées');
            }

            if($user->getRoles()[0] === "ROLE_REF") {
                return $this->redirectToRoute('app_referent_home');
            } else {
                return $this->redirectToRoute('app_coordinator_home');
            }
        }

        return $this->render('referent/addStudent.html.twig', [
            'pageTitle' => $pageTitle,
            'form' => $form
        ]);
    }
}
