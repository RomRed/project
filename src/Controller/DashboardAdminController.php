<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Avispost;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Commentaire; // Assurez-vous d'ajouter l'importation pour la classe Commentaire

class DashboardAdminController extends AbstractController
{
    #[Route('/dashboard/admin', name: 'app_dashboard_admin')]
    public function index(EntityManagerInterface $entityManager, Security $security,UtilisateurRepository $userRepo): Response
    {
        // Si l'utilisateur n'est pas connecté en tant qu'admin, redirigez-le vers la page de connexion admin
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('dashboard_utilisateur');
        }

        $users = $userRepo -> findAll();

        return $this->render('dashboard_admin/index.html.twig', [
            'controller_name' => 'DashboardAdminController',
            'users' => $users,
        ]);
    }
}
