<?php

namespace App\Controller;

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
    
        // Supprimer tous les avis liés à ce post
        $sqlDeleteAvis = "DELETE FROM avispost WHERE id_post = :postId";
        $em->getConnection()->executeStatement($sqlDeleteAvis, ['postId' => $postId]);
    
        // Supprimer tous les commentaires liés à ce post
        $sqlDeleteComments = "DELETE FROM commentaire WHERE id_post = :postId";
        $em->getConnection()->executeStatement($sqlDeleteComments, ['postId' => $postId]);
    
        // Supprimer le post
        $sqlDeletePost = "DELETE FROM post WHERE id_post = :postId";
        $em->getConnection()->executeStatement($sqlDeletePost, ['postId' => $postId]);
    
        $this->addFlash('success', 'Le post et tous ses commentaires ont été supprimés avec succès.');
    
        // Redirection vers la page précédente
        return $this->redirect($request->headers->get('referer'));
    }
}
  