<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('mot_de_passe', TextType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-control']
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Mail',
                'attr' => ['class' => 'form-control']
            ])
            ->add('estEmployeur', CheckboxType::class, [
                'label' => 'Employeur',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
             ->add('save', SubmitType::class, [
                'label' => $options['is_edit'] ? "S'incrire" : "S'inscrire",
                'attr' => ['class' => 'btn']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => True,
        ]);
    }
}