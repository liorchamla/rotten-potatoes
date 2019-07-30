<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use App\Entity\People;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => "Titre", 'attr' => ['placeholder' => "Titre du film"]])
            ->add('slug', TextType::class, ['label' => "Alias URL", 'attr' => ['placeholder' => "URL de la page (automatique)"]])
            ->add('poster', UrlType::class, ['label' => "Poster", 'attr' => ['placeholder' => 'URL du poster']])
            ->add('releasedAt', DateType::class, ['label' => "Date de sortie", 'widget' => "single_text"])
            ->add('synopsis', TextareaType::class, ['label' => "Synopsis", "attr" => ['placeholder' => 'Résumé du film']])
            ->add('categories', EntityType::class, [
                'label' => "Catégories",
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('actors', EntityType::class, [
                'label' => "Acteurs",
                'class' => People::class,
                'choice_label' => 'fullName',
                'multiple' => true
            ])
            ->add('director', EntityType::class, [
                'label' => "Réalisateur",
                'class' => People::class,
                'choice_label' => 'fullName'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
