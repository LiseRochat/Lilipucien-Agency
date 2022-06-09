<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class, [
                'required' => true,
                'label' => 'Titre de l\'annonce'
            ])
            ->add('prix', NumberType::class)
            ->add('description', TextareaType::class)
            ->add('ville', TypeTextType::class)
            ->add('save', SubmitType::class, [
                    'label' => 'Envoyer'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
