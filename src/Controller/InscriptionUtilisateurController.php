<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InscriptionUtilisateurController extends AbstractController
{
    #[Route('/inscription-utilisateur', name: 'app_inscription_utilisateur')]
    public function inscription(  SessionInterface $session, Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        
        
        $utilisateurForm = $this->createForm(InscriptionUtilisateurType::class);
        $utilisateurForm->handleRequest($request);
        
        if ($utilisateurForm->isSubmitted() && $utilisateurForm->isValid()) {
            $prenom = $utilisateurForm->get('prenomUtilisateur')->getData();
            $mdp =  $utilisateurForm->get('mdpUtlisateur')->getData();
            $email = $utilisateurForm->get('emailUtilisateur')->getData();
            $tel = $utilisateurForm->get('telephone')->getData();

            
                $hashedPassword = $passwordHasher->hashPassword($utilisateur, $mdp);
                $utilisateur->setMdpUtlisateur($hashedPassword);
                $utilisateur->setPrenomUtilisateur($prenom);
                $utilisateur->setEmailUtilisateur($email);
                $utilisateur->setTelephone($tel);
                $utilisateur->setRoleUtlisateur("ROLE_USER");
                $utilisateur->setCompteurpoint(0);
                $entityManager->persist($utilisateur);
                $entityManager->flush();

                $this->addFlash('success', 'Inscription réussie ! Connectez-vous avec votre nouveau compte.');
                return $this->redirectToRoute('app_connexion_deconnexion');
            }
        


        return $this->render('inscription_utilisateur/index.html.twig', [
            'utilisateurForm' => $utilisateurForm->createView(),
        ]);
    }
}
