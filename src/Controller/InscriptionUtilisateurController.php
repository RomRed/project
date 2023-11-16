<?php

namespace App\Controller;


use App\Entity\Outils;
use App\Entity\Utilisateur;
use App\Form\InscriptionUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionUtilisateurController extends AbstractController
{
    #[Route('/inscription-utilisateur', name: 'app_inscription_utilisateur')]
    public function inscription(  SessionInterface $session, Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $outil = new Outils();
        $utilisateur = new Utilisateur();
        
        
        $utilisateurForm = $this->createForm(InscriptionUtilisateurType::class);
        $utilisateurForm->handleRequest($request);
        


        if ($utilisateurForm->isSubmitted() && $utilisateurForm->isValid()) {

            $prenom = $utilisateurForm->get('prenomUtilisateur')->getData();
            $mdp =  $utilisateurForm->get('mdpUtlisateur')->getData();
            $email = $utilisateurForm->get('emailUtilisateur')->getData();
            $tel = $utilisateurForm->get('telephone')->getData();
            
            $existingUser = $entityManager->getRepository(Utilisateur::class)->findOneBy(['emailUtilisateur' => $email]);
            if ($existingUser) {
                $error_message = "Cette adresse email est déjà utilisée.";
                $this->addFlash('error', $error_message);
                return $this->redirectToRoute('app_inscription_utilisateur');
            }


            if (!$outil->validerEmail($email)) {
                $error_message = "L'email n'est pas valide";
                $this->addFlash('error', $error_message);
                
                return $this->redirectToRoute('app_inscription_utilisateur');
             } 
        
        
            if ($outil->validPassword($mdp)!=1) {
                $error_message = "Le mot de passe doit avoir au moins 4 caractères.";
                $this->addFlash('error', $error_message);
                
                return $this->redirectToRoute('app_inscription_utilisateur');
            }

            if (!$outil->onlyStrings($prenom)) {
                $error_message = "Le prenom doit contenir uniquement des lettres";
                $this->addFlash('error', $error_message);
                
                return $this->redirectToRoute('app_inscription_utilisateur');
            }

            if (!$outil->ValidPhoneNumber($tel)) {
                $error_message = "Le numéro de téléphone doit contenir 10 chiffres";
                $this->addFlash('error', $error_message);
                
                return $this->redirectToRoute('app_inscription_utilisateur');
            }

            
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
