<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required'=> true,
                'label'=> 'Email :',
                'attr' => [
                    'placeholder' => 'votre@email.com'
                ]
            ])
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Votre Nom'
                ]
            ])
            ->add('message', TextareaType::class, [
                'required'=> true,
                'label' => 'Votre Message',
                'attr'=> [
                    'placeholder' => 'Tapez votre message ici'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
