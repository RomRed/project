<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Station;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CreePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('contenuPost', TextareaType::class, [
            'attr' => ['class' => 'form-control',  'placeholder' => 'panne d\'ascenceur... Travaux.... '],
            'label'=> 'Message :'
        ])
        ->add('idStation', EntityType::class, [
            'class' => Station::class,
            'label'=> 'Stations :',
            'choice_label' => function (Station $station) {
                return $station->getNomStation() . ' - Ligne ' . $station->getLigne();
            },
            'attr' => ['class' => 'form-control'] // Ajoutez la classe Bootstrap pour le champ select
        ])
        ->add('idCategorie', EntityType::class, [
            'class' => Categorie::class,
            'choice_label' => 'libCategorie',
            'label'=> 'panne de ? :',
            'attr' => ['class' => 'form-control'] // Ajoutez la classe Bootstrap pour le champ select
        ])
        ->add('postConfirmer', HiddenType::class, [
            'data' => 0,
        ])
        ->add('latPost', HiddenType::class)

        ->add('longPost', HiddenType::class)
        
        ->add('postInfirmer', HiddenType::class, [
            'data' => 0,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
