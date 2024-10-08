<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\User;
use App\Form\AdminAddUserType;
use App\Repository\SkillFrameworkRepository;
use App\Repository\StructureRepository;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
    public function addUser(Structure $structure, Request $request, UserPasswordHasherInterface $hasher, JWTService $jwt, EntityManagerInterface $em, MailerInterface $mailer) : Response
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
                return $this->redirectToRoute('add_user', ['id'=>$structure->getId()]);
            }

            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            $payload = [
                'user_id' => $user->getId()
            ];

            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            $email = (new TemplatedEmail())
                ->from(new Address('admin@apc.e2c-app-factory.fr', 'Plateforme APC'))
                ->to(new Address($user->getEmail(), $user->getFirstname()." ".$user->getLastname()))
                ->subject('Activation de votre compte sur la plateforme APC')
                ->htmlTemplate('email/activate.html.twig')
                ->context([
                    'user' => $user,
                    'token' => $token
                ]);

            try {
                $mailer->send($email);
            } catch(TransportExceptionInterface $e) {
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
