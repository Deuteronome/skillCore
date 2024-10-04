<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminAddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $structure = $options['structure'];

        $siteChoice = [];

        foreach($structure->getSites() as $site) {
            $siteChoice[$site->getName()] = $site;
        }      
        
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire'
                    ])
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Coordinateur' => 'ROLE_COORD',
                    'Référent pédagogique' => 'ROLE_REF'
                ],
                'label'=> 'Type de compte',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire'
                    ])
                ]
            ])         
            ->add('firstname', TypeTextType::class, [
                'label'=>'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire'
                    ])
                ]
            ])
            ->add('lastname', TypeTextType::class, [
                'label'=>'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire'
                    ])
                ]
            ])           
            ->add('site', ChoiceType::class, [
                'choices' => $siteChoice,
                'label' => 'Site'
            ])
            ->add('create', SubmitType::class, [
                'label' => 'Créer utilisateur',
                'attr' => [
                    'class' =>'btn btn-sec-custom mt-3'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'structure' => null
        ]);

        $resolver->setAllowedTypes('structure', 'App\Entity\Structure');
    }
}
