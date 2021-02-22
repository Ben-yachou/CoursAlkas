<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class PictureModifyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pictureFile', FileType::class, [
            'label' => 'Profile Picture',
            //on précise au formulaire de ne pas ranger lui même la donnée, car on ne veut stocker que le nom du fichier 
            'mapped' => false,
            'required' => false,
            //le champ n'étant pas mappé à l'entité on doit définir les contraintes ici
            'constraints' => [
                //la contrainte de type File permet de définir des contraintes associées aux fichiers
                new File([
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Only PNG and JPG are allowed',
                    'maxSize' => '2048k'
                ])
            ],
        ])
            ->add('deletePicture', CheckboxType::class, [
                'label' => 'Revert picture to default',
                'required' => false,
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modify Picture'
            ]);
    }
}
