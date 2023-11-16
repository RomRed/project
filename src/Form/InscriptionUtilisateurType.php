<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class InscriptionUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('telephone',TextType::class ,[
            'attr' => ['class' => 'form-control', 'placeholder' => 'Téléphone'],
            'label' => false
        ])
        ->add('prenomUtilisateur',TextType::class , [
            'attr' => ['class' => 'form-control',  'placeholder' => 'Prenom/Pseudo'],
            'label' => false
        ])
        ->add('emailUtilisateur',EmailType::class , [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Email'],
            'label' => false
        ])
        ->add('mdpUtlisateur', PasswordType::class , [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Mot de passe'],
            'label' => false
        ])
        // ->add('roleUtlisateur',HiddenType::class ,[
        //     'data' => 'ROLE_USER',
        // ], [
        //     'attr' => ['class' => 'form-control']
        // ])
        ->add('compteurpoint', HiddenType::class, [
            'data' => 0,
        ], [
            'attr' => ['class' => 'form-control mb-2']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
