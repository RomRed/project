<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{





    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user->getRoleUtlisateur() == 'ROLE_ADMIN') {
            // Rediriger l'administrateur vers le tableau de bord de l'admin
            return $this->redirectToRoute('app_dashboard_admin');
        } elseif ($user->getRoleUtlisateur() == 'ROLE_USER') {
            // Rediriger l'utilisateur vers le tableau de bord de l'utilisateur
            return $this->redirectToRoute('dashboard_utilisateur');
        } else {
            // Gérer d'autres rôles au besoin
            throw $this->createAccessDeniedException('Accès refusé.');
        }
    }
}