<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionUtilisateurController extends AbstractController
{
    #[Route('/connexion', name: 'app_connexion')]
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

    #[Route('/deconnexion', name: 'app_connexion_deconnexion')]
    public function deconnexion(): Response
    {
        return $this->render('connexion_utilisateur/index.html.twig', [
            'controller_name' => 'ConnexionUtilisateurController',
        ]);
    }

}
