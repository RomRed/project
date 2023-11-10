<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\Station;
use App\Entity\Avispost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    private ManagerRegistry $managerRegistry;
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $managerRegistry, EntityManagerInterface $entityManager)
    {
        $this->managerRegistry = $managerRegistry;
        $this->entityManager = $entityManager;
    }

/**
 * @Route("/publications", name="publications")
 */
public function index(Request $request): Response
{
    // Récupérez la liste des posts
    $posts = $this->managerRegistry->getRepository(Post::class)->findAll();
    $post = $this->managerRegistry->getRepository(Post::class)->findAll();
    $station = $this->managerRegistry->getRepository(Station::class)->findAll();
    $stations = $this->managerRegistry->getRepository(Station::class)->findAll();
    // Ajoutez le code pour récupérer les commentaires associés à chaque post
    $commentsByPost = [];

    foreach ($posts as $post) {
        $comments = $this->entityManager->getRepository(Commentaire::class)->findBy(['idPost' => $post]);
        $commentsByPost[$post->getIdPost()] = $comments;
    }

    // Créez un nouveau commentaire vide
    $comment = new Commentaire();
    $commentForm = $this->createForm(CommentaireType::class, $comment);

    // Gérez la soumission du formulaire de commentaire
    $commentForm->handleRequest($request);

    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        // Associez le commentaire au poste et à l'utilisateur
        $comment->setIdPost($post);
        $comment->setIdUtlisateur($this->getUser());

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    return $this->render('post/index.html.twig', [
        'post' => $post,
        'posts' => $posts,
        'station' => $station,
        'stations'=>  $stations,
        'commentsByPost' => $commentsByPost,
        'commentForm' => $commentForm->createView(),
    ]);
}


    /**
     * @Route("/post/confirm/{id}", name="post_confirm")
     */
    public function confirmPost(Request $request, $id, Security $security): Response
    {
        $entityManager = $this->entityManager;
        $post = $this->entityManager->getRepository(Post::class)->find($id);
        $user = $this->getUser(); // Récupérez l'utilisateur connecté
    
        if (!$post || !$user) {
            // Gérer le cas où le post ou l'utilisateur n'existe pas
            // Redirigez ou affichez un message d'erreur approprié
        }
    
        // Vérifiez si l'utilisateur est le propriétaire du post
        if ($post->getIdUtlisateur() === $user) {
            // L'utilisateur ne peut pas infirmer son propre post
            $this->addFlash('error', 'Vous ne pouvez pas confirmer votre propre post.');
            return $this->redirectToRoute('publications');
        }
    
        // Vérifiez si l'utilisateur a déjà confirmé ce post
        $existingAvis = $this->entityManager->getRepository(Avispost::class)->findOneBy([
            'idPost' => $post,
            'idUtlisateur' => $user,
            // 'isvrai' => true, // Vérifiez si l'utilisateur a déjà confirmé le post
        ]);
    
        if ($existingAvis) {
            // L'utilisateur a déjà infirmé ce post
            $this->addFlash('error', 'Vous avez déjà confirmé/infirmé ce post.');
            return $this->redirectToRoute('publications');
        }
    
        // Créez un avis pour confirmer le post
        $avis = new Avispost();
        $avis->setIsvrai(true); // "true" signifie confirmé
        $avis->setIdPost($post);
        $avis->setIdUtlisateur($user);
    
        $entityManager->persist($avis);
        $post->setPostConfirmer($post->getPostConfirmer() + 1);
    
        // Mettez à jour le compteur de points de l'utilisateur qui a fait le post
        $utilisateurDuPost = $post->getIdUtlisateur();
        $utilisateurDuPost->setCompteurpoint($utilisateurDuPost->getCompteurpoint() + 5);
    
        $entityManager->persist($post);
        $entityManager->flush();
    
        return $this->redirectToRoute('publications');
    }
    

    /**
     * @Route("/post/infirm/{id}", name="post_infirm")
     */
    public function infirmPost(Request $request, $id, Security $security): Response
    {
        
        $entityManager = $this->entityManager;
        $post = $this->entityManager->getRepository(Post::class)->find($id);
        $user = $this->getUser(); // Récupérez l'utilisateur connecté
    
        if (!$post || !$user) {
            // Gérer le cas où le post ou l'utilisateur n'existe pas
            // Redirigez ou affichez un message d'erreur approprié
        }
    
        // Vérifiez si l'utilisateur est le propriétaire du post
        if ($post->getIdUtlisateur() === $user) {
            // L'utilisateur ne peut pas infirmer son propre post
            $this->addFlash('error', 'Vous ne pouvez pas infirmer votre propre post.');
            return $this->redirectToRoute('publications');
        }
    
        // Vérifiez si l'utilisateur a déjà infirmé ce post
        $existingAvis = $this->entityManager->getRepository(Avispost::class)->findOneBy([
            'idPost' => $post,
            'idUtlisateur' => $user,
            // 'isvrai' => false, // Vérifiez si l'utilisateur a déjà infirmé le post
        ]);
    
        if ($existingAvis) {
            // L'utilisateur a déjà infirmé ce post
            $this->addFlash('error', 'Vous avez déjà infirmé/confirmé ce post.');
            return $this->redirectToRoute('publications');
        }
    
        // Créez un avis pour infirmer le post
        $avis = new Avispost();
        $avis->setIsvrai(false); // "false" signifie infirmé
        $avis->setIdPost($post);
        $avis->setIdUtlisateur($user);
    
        $entityManager->persist($avis);
        $post->setPostInfirmer($post->getPostInfirmer() + 1);
    
        // Mettez à jour le compteur de points de l'utilisateur qui a fait le post
        $utilisateurDuPost = $post->getIdUtlisateur();
        $utilisateurDuPost->setCompteurpoint($utilisateurDuPost->getCompteurpoint() - 2);
    
        $entityManager->persist($post);
        $entityManager->flush();
    
        return $this->redirectToRoute('publications');
    }
        
/**
 * @Route("/comment/{id}", name="comment")
 */
public function addComment(Request $request, $id): Response
{
    $post = $this->managerRegistry->getRepository(Post::class)->find($id);

    if (!$post) {
        // Gérez le cas où le post n'existe pas
        // Vous pouvez afficher un message d'erreur ou rediriger vers une autre page
    } else {
        $comment = new Commentaire();
        $commentForm = $this->createForm(CommentaireType::class, $comment);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Associez le commentaire au post et à l'utilisateur
            $comment->setIdPost($post);
            $comment->setIdUtlisateur($this->getUser());

            $this->entityManager->persist($comment);
            $this->entityManager->flush();
        }


        // Redirigez ou affichez la page des publications après avoir ajouté le commentaire
        return $this->redirectToRoute('publications');
    }
}

}


