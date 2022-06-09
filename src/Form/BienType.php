<?php

namespace App\Form;

use App\Entity\Bien;
use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class, [
                'required' => true,
                'label' => 'Titre de l\'annonce',
                'attr' => [
                    'placeholder' => 'Maison de village',
                ],
            ])
            ->add('prix', NumberType::class, [
                'required' => false,
                'label' => 'Prix du bien immobilier',
                'attr' => [
                    'placeholder' => '800 000 euros',
                ],
                'invalid_message' => 'Vous avez entrez un nombre invalide. Le minimum est %num%',
                'invalid_message_parameters' => ['%num%' => 6],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description présentant votre bien immobilier',
                'attr' => [
                    'placeholder' => 'Maison 100 mètre carré. 3 chambres, deux salles de bains, cuisine équipé. Salon de 30 mètre carré. Veranda sur jardin de 200 mètre carré. Situé en plein coeur du premier arrondissement de Lyon. Bien rare à visiter sans tarder !',
                ],
            ])
            ->add('ville', TypeTextType::class, [
                'required' => false,
                'label' => 'Localisation du bien',
                'attr' => [
                    'placeholder' => 'Lyon 69001',
                ],
            ])
            ->add('status', EntityType::class, [
                'required' => false,
                'class' => Status::class,
                'choice_label' => 'title'
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
