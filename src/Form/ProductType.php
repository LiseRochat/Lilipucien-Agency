<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Le nom de votre produit'
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix du produit',
                'attr' => [
                    'placeholder' => '50.6'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description du produit',
                'attr' => [
                    'placeholder' => 'Renseignez une description précise de votre produit.'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
