<?php

namespace App\Form;

use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->colorFree = $options['colorFree'];
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom du statu',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description du statu'
            ])
            ->add('color', ChoiceType::class, [
                'required' => false,
                'choices' => $this->colorFree,
                'label' => 'Couleur du statu'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
            'colorFree' => null,
        ]);
    }
}
