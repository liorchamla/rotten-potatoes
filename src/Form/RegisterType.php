<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email', 'attr' => ['placeholder' => 'Votre adresse email']])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Vos mot de passe ne correspondent pas",
                'first_options' => ['label' => "Mot de passe", 'attr' => ['placeholder' => "Votre mot de passe"]],
                'second_options' => ['label' => "Confirmation de mot de passe", 'attr' => ['placeholder' => "Confirmez le mot de passe"]]
            ])
            ->add('name', TextType::class, ['label' => "Nom d'utilisateur", 'attr' => ['placeholder' => 'Votre pseudonyme']])
            ->add('avatar', UrlType::class, ['label' => "Avatar", 'attr' => ['placeholder' => 'URL de votre avatar']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
