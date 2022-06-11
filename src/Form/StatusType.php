<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\ColorsStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom du statu',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description du statu'
            ])
            ->add('color', EntityType::class, [
                'required' => false,
                'class' => ColorsStatus::class,
                'choice_label' => 'name',
                'label' => 'Couleur du statu'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
        ]);
    }
}
