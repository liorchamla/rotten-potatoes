<?php

namespace App\Form;

use App\Entity\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextareaType::class, ['label' => "Commentaire", 'attr' => ['placeholder' => "Votre commentaire sur le film"]])
            ->add('notation', ChoiceType::class, [
                'label' => "Notation",
                'choices' => [
                    "1 / 5" => 1,
                    "2 / 5" => 2,
                    "3 / 5" => 3,
                    "4 / 5" => 4,
                    "5 / 5" => 5,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}
