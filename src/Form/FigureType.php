<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Figure;
use App\Entity\Groupe;
use App\Repository\FigureRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'class' => Groupe::class,
                'choice_label' => 'name',
                'query_builder' => function (GroupeRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
            ])
            ->add('name', TextType::class, ["label" => "Nom de la figure"])
            ->add('description', TextareaType::class, ["label" => "Description de la figure"])
            ->add("images", FileType::class, [
                "mapped" => false,
                "required" => false,
                "label" => "Télécharger une image pour illustrer votre figure"
            ])
            ->add(
                "videos",
                UrlType::class,
                [
                    "mapped" => false,
                    "required" => false,
                    "label" => "Insérez une vidéo à partir de son url"
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
