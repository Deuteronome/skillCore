<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as TypePasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', TypePasswordType::class, [
                'label' => 'Définir mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire'
                    ])
                ]
            ])
            ->add('confirmPassword', TypePasswordType::class, [
                'label' => 'Confirmer le mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Confirmer',
                'attr' => [
                    'class' => 'btn btn-lg btn-sec-custom'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
