<?php

namespace App\Form;

use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class,  [
                'required' => true,
                'label' => 'NOm du status',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }
}
