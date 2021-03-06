<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom du produit',
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix du produit',
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description du produit',
                
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'Ville du Produit',
            ])
            ->add('surface', NumberType::class, [
                'required' => true,
                'label' => 'Surface du Produit',
            ])
            ->add('nb_garage', NumberType::class, [
                'required' => true,
                'label' => 'Nombre de garage appartenant au produit',
            ])
            ->add('cellar', CheckboxType::class, [
                'required' => false,
                'label' => 'Présence d\'une cave',
            ])
            ->add('nb_bedroom', NumberType::class, [
                'required' => true,
                'label' => 'Nombre de chambre',
            ])
            ->add('status', EntityType::class, [
                'required' => false,
                'class' => Status::class,
                'choice_label' => 'title',
                'label' => 'Status du Produit',              
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Image Principal du bien',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
