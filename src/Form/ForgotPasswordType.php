<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ForgotPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'Les adresses e-mail ne sont pas identiques.',
                'options' => ['attr' => ['class' => 'password-field',
                'class'=> 'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Saisir votre adress e-mail'],
                'second_options' => ['label' => 'Confirmez votre adress e-mail'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

         'data_class'=> User::class,

        ]);
    }

}