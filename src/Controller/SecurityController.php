<?php

namespace App\Controller;

use App\Form\PasswordType;
use App\Repository\UserRepository;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        if($this->getUser()) {
            $this->redirectToRoute('app_main');
        }
        
        $pageTitle = "Connexion";
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'pageTitle' => $pageTitle
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path:'/activation/{token}', name:'app_password')]
    public function definePassword(string $token,Request $request, JWTService $jwt, UserRepository $userRepository, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $pageTitle = 'Définition de mot de passe';
        
        if($this->getUser()) {
            $this->redirectToRoute('app_main');
        }
        
        if(!$jwt->signatureCheck($token, $this->getParameter('app.jwtsecret'))) {
            $this->addFlash('danger', 'Lien invalide');
            return $this->redirectToRoute('app_main');
        }

        if($jwt->isExpired($token)) {
            $this->addFlash('danger', 'Lien expiré');
            return $this->redirectToRoute('app_main');
        }

        $user = $userRepository->findOneById($jwt->getPayload($token)['user_id']);

        if(!$user->isActive()) {
            $this->addFlash('danger', 'Compte désactivé');
            return $this->redirectToRoute('app_main');
        }

        $form = $this->createForm(PasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('plainPassword')->getData() !== $form->get('confirmPassword')->getData()) {
                $this->addFlash('warning', 'Les deux mots de passes doivent être identiques');
                return $this->redirectToRoute('app_password', ['token' => $token]);
            }

            $user->setPassword(
                $hasher->hashPassword($user, $form->get('plainPassword')->getData())
            );

            $em->persist($user);

            try {
                $em->flush();
                $this->addFlash('success', 'mot de passe modifié');
            } catch(Exception $e) {
                $this->addFlash('danger', 'Le mot de passe n\'a pas pu être modifié');
                return $this->redirectToRoute('app_password', ['token' => $token]);
            }

            return $this->redirectToRoute('app_main');
        }
        
        return $this->render('security/password.html.twig', [
            'pageTitle' => $pageTitle,
            'user' => $user,
            'form' => $form
        ]);
    }
}
