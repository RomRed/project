<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Avispost;
use App\Entity\Commentaire;
use App\Entity\Aviscommentaire;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirPostAdminController extends AbstractController
{
    #[Route('/voir-post-admin/{id}', name: 'app_voir_post_admin')]
    public function index(PostRepository $postRepo,$id): Response
    {
        $posts = $postRepo -> findByIdUtlisateur($id);
        
        return $this->render('voir_post_admin/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/supprimer-post-admin/{id}', name: 'app_supprimer_post_admin')]
    
    public function supprimerPost(
        PostRepository $postRepo,
        EntityManagerInterface $em,
        Request $request,
        $id
    ): Response {
        $postId = (int) $id;
    
    // Récupérez les avis posts liés à ce post
    $avisPosts = $em->getRepository(Avispost::class)->findBy(['idPost' => $postId]);

    // Supprimez tous les avis posts liés à ce post
    foreach ($avisPosts as $avisPost) {
        $em->remove($avisPost);
    }

    $em->flush(); // Suppression des avis posts liés

    // Récupérez les commentaires liés à ce post
    $comments = $em->getRepository(Commentaire::class)->findBy(['idPost' => $postId]);

    foreach ($comments as $comment) {
        // Récupérez les avis commentaires liés à ce commentaire
        $avisComments = $em->getRepository(Aviscommentaire::class)->findBy(['idCommentaire' => $comment->getIdCommentaire()]);

        // Supprimez tous les avis commentaires liés à ce commentaire
        foreach ($avisComments as $avisComment) {
            $em->remove($avisComment);
        }

        $em->flush(); // Suppression des avis commentaires liés

        // Supprimez le commentaire
        $em->remove($comment);
    }

    // Supprimer le post
    $post = $em->getRepository(Post::class)->find($postId);
    $em->remove($post);

    $em->flush(); // Suppression du post

    $this->addFlash('success', 'Le post et tous ses commentaires ont été supprimés avec succès.');

    // Redirection vers la page précédente
    return $this->redirect($request->headers->get('referer'));
}
}
  