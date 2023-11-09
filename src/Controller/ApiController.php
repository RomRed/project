<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    
    #[Route('/api', name: 'app_api')]
    public function getUsers()
{
    
    $userRepository  = $this->managerRegistry->getRepository(Utilisateur::class);
    $users = $userRepository->findAll();

    $data = [];

    foreach ($users as $user) {
        $data[] = [
            'idUtilisateur' => $user->getIdUtlisateur(),
            'prenomUtilisateur' => $user->getPrenomUtilisateur(),
            'emailUtilisateur' => $user->getEmailUtilisateur(),
            'MDPUtilisateur' => $user->getMdpUtlisateur(),
        ];
    }


    return new JsonResponse($data);
}

#[Route('/api/posts', name: 'app_api')]
public function getPosts()
{
$postRepository  = $this->managerRegistry->getRepository(Post::class);

$posts = $postRepository->findAll();

$data = [];


foreach ($posts as $post) {
    $data[] = [
        'idPost' => $post->getIdPost(),
        'contenuPost' => $post->getContenuPost(),
        'postConfirmer' => $post->getPostConfirmer(),
        'postInfirmer' => $post->getPostInfirmer(),
        // 'idStation' => $post->getIdStation(),
        // 'idUtilisateur' => $post->getIdUtlisateur(),
        // 'idCategorie' => $post->getIdCategorie(),
    ];
}

return new JsonResponse($data);
}

#[Route('/api/posts', name: 'create_post', methods: ['POST'])]
public function createPost(Request $request): Response
{
    // Récupérez les données JSON envoyées depuis Ionic
    $postData = json_decode($request->getContent(), true);

    // Créez un nouvel objet Post et remplissez-le avec les données
    $post = new Post();
    $post->setContenuPost($postData['contenuPost']); // Assurez-vous d'ajouter les autres propriétés

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($post);
    $entityManager->flush();

    return new JsonResponse(['message' => 'Post créé avec succès'], Response::HTTP_CREATED);
}

#[Route('/api/posts/{id}', name: 'update_post', methods: ['PUT'])]
public function updatePost(Request $request, $id): Response
{
    // Récupérez l'ID du post depuis Ionic
    $postData = json_decode($request->getContent(), true);

    $entityManager = $this->getDoctrine()->getManager();
    $post = $entityManager->getRepository(Post::class)->find($id);

    if (!$post) {
        return new JsonResponse(['message' => 'Post non trouvé'], Response::HTTP_NOT_FOUND);
    }

    // Mettez à jour les propriétés du post avec les nouvelles données
    $post->setContenuPost($postData['contenuPost']); // Assurez-vous de mettre à jour les autres propriétés

    $entityManager->persist($post);
    $entityManager->flush();

    return new JsonResponse(['message' => 'Post mis à jour avec succès'], Response::HTTP_OK);
}

#[Route('/api/posts/{id}', name: 'delete_post', methods: ['DELETE'])]
public function deletePost($id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $post = $entityManager->getRepository(Post::class)->find($id);

    if (!$post) {
        return new JsonResponse(['message' => 'Post non trouvé'], Response::HTTP_NOT_FOUND);
    }

    $entityManager->remove($post);
    $entityManager->flush();

    return new JsonResponse(['message' => 'Post supprimé avec succès'], Response::HTTP_OK);
}

}

