<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Pizza;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price', MoneyType::class, [
                'divisor' => 100
            ])
            ->add('photoFile', FileType::class, [
                //on précise au formulaire de ne pas ranger lui même la donnée, car on ne veut stocker que le nom du fichier 
                'mapped' => false,
                'required' => true,
                //le champ n'étant pas mappé à l'entité on doit définir les contraintes ici
                'constraints' => [
                    new NotNull(),
                    //la contrainte de type File permet de définir des contraintes associées aux fichiers
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Only PNG and JPG are allowed',
                        'maxSize' => '2048k'
                    ])
                ],
            ])
            ->add('base')
            ->add('ingredients', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Ingredient::class
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
        ]);
    }
}
