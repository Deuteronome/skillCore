<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ActivateUserService {

    private $params;
    private $jwt;
    private $mailer;

    public function __construct(ParameterBagInterface $params, JWTService $jwt, MailerInterface $mailer)
    {
        $this->params = $params;
        $this->jwt = $jwt;
        $this->mailer = $mailer;
    }

    public function getToken(User $user):string {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $payload = [
            'user_id' => $user->getId()
        ];

        return $this->jwt->generate($header, $payload, $this->params->get('app.jwtsecret'));
    }

    public function activate(User $user):Bool
    {
        $success = true;
        
        $token = $this->getToken($user);

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
            $this->mailer->send($email);
        } catch(TransportExceptionInterface $e) {
            $success = false;
        }
        
        return $success;
    }

}