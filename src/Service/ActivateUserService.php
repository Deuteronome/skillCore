<?php

namespace App\Service;

use App\Entity\Tracker;
use App\Entity\User;
use App\Repository\SkillFrameworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ActivateUserService {

    private $params;
    private $jwt;
    private $mailer;
    private $em;   

    public function __construct(ParameterBagInterface $params, JWTService $jwt, MailerInterface $mailer, EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->jwt = $jwt;
        $this->mailer = $mailer; 
        $this->em = $em;
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

    public function studentTracker(User $user):bool
    {
        $success = true;
        $skillList = [];

        foreach($user->getSite()->getStructure()->getSkillFrameworks() as $framework) {
            $baseLevel = null;

            foreach($framework->getLevels() as $level) {
                if ($level->getHierarchy()===0) {
                    $baseLevel=$level;
                }
            }

            foreach($framework->getDomains() as $domain) {
                foreach($domain->getSkills() as $skill) {
                    $tracker = new Tracker();
                    $tracker->setUser($user);
                    $tracker->setSkill($skill);
                    $tracker->setLevel($baseLevel);

                    $this->em->persist($tracker);
                    $skillList[]=$tracker;
                }
            }
        }

        try {
            $this->em->flush();
        } catch(Exception $e) {
            $success = false;
        }

        return $success;
    }

}