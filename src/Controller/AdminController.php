<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\User;
use App\Form\AdminAddUserType;
use App\Repository\SkillFrameworkRepository;
use App\Repository\StructureRepository;
use App\Service\ActivateUserService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/accueil', name: 'home')]
    public function adminHome(StructureRepository $structureRepository): Response
    {
        $pageTitle = "Tableau de bord";

        $structureList = $structureRepository->findAll();
        $structuresCount = [];

        foreach($structureList as $structure) {
            $structureCount = [
                'coordCount' => 0
            ];

            foreach($structure->getSites() as $site) {

                $userNumber = [
                    'ref' => 0,
                    'stag' => 0
                ];

                foreach($site->getUsers() as $user) {
                    
                    switch($user->getRoles()[0]) {
                        case "ROLE_REF":
                            $userNumber["ref"]++;
                            break;
                        case "ROLE_STUDENT":
                            $userNumber["stag"]++;
                            break;
                        default:
                            $structureCount['coordCount']++;
                            break;
                    }
                }

                $structureCount[$site->getName()]= $userNumber;
            }

            $structuresCount[$structure->getName()] = $structureCount;
        }
        
        return $this->render('admin/home.html.twig', [
            'pageTitle' => $pageTitle,
            'structureList' => $structureList,
            'structureCount' => $structuresCount
        ]);
    }

    #[Route('/ajout/utilisateur/{id}', name: 'add_user')]
    public function addUser(Structure $structure, Request $request, UserPasswordHasherInterface $hasher,EntityManagerInterface $em, ActivateUserService $activateUser) : Response
    {
        $pageTitle = 'Ajout utilisateur : ' .$structure->getName();
        $user = new User();

        $form = $this->createForm(AdminAddUserType::class, $user, ['structure' => $structure]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setRoles([$form->get('roles')->getData()]);

            $password = $this->getParameter('app.passwddef');
            $user->setPassword(
                $hasher->hashPassword($user, $password)
            );

            $user->setActive(true);

            $em->persist($user);

            try {
                $em->flush();
                $this->addFlash('success', 'Compte utilisateur créé');
            } catch(Exception $e) {
                $this->addFlash('danger', 'Problème lors de la création du compte utilisateur');
                return $this->redirectToRoute('app_admin_add_user', ['id'=>$structure->getId()]);
            }

            $activationSuccess = $activateUser->activate($user);

            if(!$activationSuccess) {
                $this->addFlash('warning', 'Le mail d\'initialisation du mot de passe n\'a pas pu être envoyé');
            }

            return $this->redirectToRoute('app_main');
        }

        return $this->render('admin/addUser.html.twig', [
            'pageTitle' => $pageTitle,
            'form' => $form
        ]);
    }

    #[Route('/structure', name:'structure')]
    public function manageStructure():Response
    {
        $pageTitle = "Gestions des structures";

        return $this->render('standBy.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }

    #[Route('/referentiel', name:'framework')]
    public function manageFramework(SkillFrameworkRepository $skillFrameworkRepository):Response
    {
        $pageTitle = "Gestion des référentiels";

        $frameworkList = $skillFrameworkRepository->findAll();

        return $this->render('admin/manageFramework.html.twig', [
            'pageTitle' => $pageTitle,
            'frameworks' => $frameworkList
        ]);
    }
}
