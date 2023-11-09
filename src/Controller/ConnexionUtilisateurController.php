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
        return $this->render('connexion_utilisateur/index.html.twig', [
            'controller_name' => 'ConnexionUtilisateurController',
        ]);
    }

    #[Route('/deconnexion', name: 'app_connexion_deconnexion')]
    public function deconnexion(): Response
    {
        return $this->render('connexion_utilisateur/index.html.twig', [
            'controller_name' => 'ConnexionUtilisateurController',
        ]);
    }

}
