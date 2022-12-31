<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Figure;
use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('CreatedAt')
            ->add('modifiedAt')
            ->add('imgfilename')
            ->add('groupe', EntityType::class, [
                'class' => Groupe::class,
                'choice_label' => 'name', // Utilisez le nom de l'entité Groupe comme étiquette de choix
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // Utilisez le nom de l'entité Author comme étiquette de choix
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
