<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Figure;
use App\Entity\Groupe;
use App\Entity\Medias;
use App\Form\MediaType;
use App\Repository\FigureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('groupe', EntityType::class, [
                'label' => "Choix du groupe de la figure",
                'class' => Figure::class,
                'choice_label' => 'name',
                'query_builder' => function (FigureRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.name', 'ASC');
                },
            ])
            ->add('name', TextType::class, ["label" => "Nom de la figure"])
            ->add('description', TextareaType::class, ["label" => "Description de la figure"])
            ->add('medias', CollectionType::class, [
                'entry_type' => MediaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
