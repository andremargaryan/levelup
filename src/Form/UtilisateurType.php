<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', IntegerType::class, [
                'label' => 'Prenom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('mdp', TextType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-control']
            ])
            ->add('mail', TextareaType::class, [
                'label' => 'Mail',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateDeNaissance', TextareaType::class, [
                'label' => 'Date naissance',
                'attr' => ['class' => 'form-control']
            ])
              ->add('profession', TextareaType::class, [
                'label' => 'Profession',
                'attr' => ['class' => 'form-control']
            ])
             ->add('save', SubmitType::class, [
                'label' => $options['exist'] ?? false ? 'se connecter' : 's/inscrire',
                'attr' => ['class' => 'btn']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'is_edit' => True,
        ]);
    }
}