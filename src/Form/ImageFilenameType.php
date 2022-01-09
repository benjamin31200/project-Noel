<?php

namespace App\Form;

use App\Entity\ImageFilename;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageFilenameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ImageFilename', FileType::class, [
                'label' => 'Image (Pnj,jpeg,tiff,webp file)',
                'mapped' => false,
                'required' => false,
                
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/tiff',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Le fichier d\'upload n\'est pas correct.',
                    ])
                ],
            ])
            ->add('Description', TextareaType::class)
            ->add('Title', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImageFilename::class,
        ]);
    }
}
