<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Avispost;
use App\Entity\Commentaire;
use App\Entity\Aviscommentaire;
use App\Form\ModificationPostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DashboardUtilisateurController extends AbstractController
{
    private $security;
    private ManagerRegistry $managerRegistry;

    private $tokenStorage;


    public function __construct(Security $security,ManagerRegistry $managerRegistry, TokenStorageInterface $tokenStorage)
    {
        $this->security = $security;
        $this->managerRegistry = $managerRegistry;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/dashboard-utilisateur', name: 'dashboard_utilisateur')]
    public function index(): Response
    {
        $user = $this->getUser(); // Obtenez l'utilisateur actuellement connecté

        if ($user) {
            $entityManager = $this->managerRegistry->getManager();
            $posts = $entityManager->getRepository(Post::class)->findBy(['idUtlisateur' => $user->getIdUtlisateur()]);
    
            // $posts contient maintenant les publications de l'utilisateur actuellement connecté
        } else {
            // L'utilisateur n'est pas connecté, effectuez la gestion appropriée ici
        }
    
        return $this->render('dashboard_utilisateur/index.html.twig', [
            'controller_name' => 'DashboardUtilisateurController',
            'posts' => $posts,
        ]);
    
}

#[Route('/modifier-post/{id}', name: 'modifier_post')]
public function modifierPost(Request $request, $id): Response
{
    $entityManager = $this->managerRegistry->getManager();
    $post = $entityManager->getRepository(Post::class)->find($id);

    // Vérifiez si l'utilisateur actuel est le propriétaire de la publication
    if ($post && $post->getIdUtlisateur() === $this->getUser()) {
        $form = $this->createForm(ModificationPostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour de la publication en base de données
            $entityManager->flush();

            // Redirection vers le tableau de bord
            return $this->redirectToRoute('dashboard_utilisateur');
        }
    } else {
        // Gérer l'erreur ou rediriger vers une page d'erreur
    }

    // Affichez le formulaire de modification
    return $this->render('post/modification.html.twig', ['form' => $form->createView()]);
}

#[Route('/supprimer-post/{id}', name: 'supprimer_post')]
public function supprimerPost(Request $request, $id): Response
{
    $entityManager = $this->managerRegistry->getManager();
    $post = $entityManager->getRepository(Post::class)->find($id);

    // Vérifiez si l'utilisateur actuel est le propriétaire de la publication
    if ($post && $post->getIdUtlisateur() === $this->getUser()) {
        // Récupére les commentaires associés à la publication
        $commentaires = $entityManager->getRepository(Commentaire::class)->findBy(['idPost' => $post]);

        // Supprime les avis commentaires associés aux commentaires de la publication
        foreach ($commentaires as $commentaire) {
            $avisCommentaires = $entityManager->getRepository(Aviscommentaire::class)->findBy(['idCommentaire' => $commentaire->getIdCommentaire()]);

            foreach ($avisCommentaires as $avisCommentaire) {
                $entityManager->remove($avisCommentaire);
            }

            $entityManager->remove($commentaire);
        }

        // Supprime les avis post associés à la publication
        $avisPosts = $entityManager->getRepository(Avispost::class)->findBy(['idPost' => $post]);

        foreach ($avisPosts as $avisPost) {
            $entityManager->remove($avisPost);
        }

        // supprime la publication
        $entityManager->remove($post);
        $entityManager->flush();

        // Redirection vers le tableau de bord
        return $this->redirectToRoute('dashboard_utilisateur');
    } else {
        // Gérer l'erreur ou rediriger vers une page d'erreur
    }
}
}
