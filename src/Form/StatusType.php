<?php

namespace App\Form;

use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class,  [
                'required' => true,
                'label' => 'Nom du status',
                'attr' => [
                    'placeholder' => 'Gardiennage',
                ],
            ])
            ->add('description', TypeTextType::class,  [
                'required' => false,
                'label' => 'Description du status',
                'attr' => [
                    'placeholder' => 'Gardez mon logement durant deux semaines',
                ],
            ])
            ->add('color', ChoiceType::class,  [
                'required' => false,
                'label' => 'Couleur de fond du status',
                'choices' => [
                    'bleu marine' => 'primary',
                    'gris' => 'secondary',
                    'vert' => 'success',
                    'rouge' => 'danger',
                    'jaune' => 'warning',
                    'bleu ciel' => 'info',
                    'gris clair' => 'light',
                    'blanc' => 'white',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }
}
