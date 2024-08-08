<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
