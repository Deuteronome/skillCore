<?php

namespace App\Controller;

use App\Form\ForgottenPasswordType;
use App\Repository\UserRepository;
use App\Service\JWTService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(AccessDecisionManagerInterface $access): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $token = new UsernamePasswordToken($this->getUser(), 'none', $this->getUser()->getRoles());
            if($access->decide($token, ['ROLE_ADMIN'])){
                return $this->redirectToRoute('app_admin_home');
            } else if($access->decide($token, ['ROLE_COORD'])){
                return $this->redirectToRoute('app_coordinator_home');
            } else if($access->decide($token, ['ROLE_REF'])){
                return $this->redirectToRoute('app_referent_home');
            } else {
                return $this->redirectToRoute('app_student_home');
            }
        }       
    }

    #[Route('/compte', name: 'app_account')]
    public function account():Response
    {
        if(!$this->getUser()) {
            $this->redirectToRoute('app_main');
        }
        
        $pageTitle = 'Info compte';

        return $this->render('main/account.html.twig', [
            'pageTitle' => $pageTitle
        ]);
    }

    #[Route(path:'/oubli', name:'app_forgotten_password')]
    public function forgottenPassword(Request $request, UserRepository $userRepository, JWTService $jwt, MailerInterface $mailer):Response
    {
        if($this->getUser()) {
            $this->redirectToRoute('app_main');
        }
        
        $pageTitle = 'Mot de passe oublié';

        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneByEmail($form->get('email')->getData());
            
            if(!$user) {
                $this->addFlash('danger', 'Adresse mail inconnue');
                return $this->redirectToRoute('app_main');
            }

            if(!$user->isActive()) {
                $this->addFlash('danger', 'Compte désactivé');
                return $this->redirectToRoute('app_main');
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
                ->subject('plateforme APC - réinitialisation de mot de passe')
                ->htmlTemplate('email/activate.html.twig')
                ->context([
                    'user' => $user,
                    'token' => $token
                ]);

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Mail de réinitialisation envoyé');
            } catch(TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Le mail d\'initialisation du mot de passe n\'a pas pu être envoyé');
            }

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/forgottenPassword.html.twig', [
            'pageTitle' => $pageTitle,
            'form' => $form
        ]);
    }
}
