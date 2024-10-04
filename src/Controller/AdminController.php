<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\User;
use App\Form\AdminAddUserType;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function addUser(Structure $structure) : Response
    {
        $pageTitle = 'Ajout utilisateur : ' .$structure->getName();
        $user = new User();

        $form = $this->createForm(AdminAddUserType::class, $user, ['structure' => $structure]);

        return $this->render('admin/addUser.html.twig', [
            'pageTitle' => $pageTitle,
            'form' => $form
        ]);
    }
}
