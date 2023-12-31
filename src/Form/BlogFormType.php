<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;

class BlogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Subtitle')
            ->add('Text')
            ->add('MainImage', FileType::class, ['mapped' => false, 'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/*'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image',
                ])
            ]])
            ->add('SubImages', FileType::class, ['mapped' => false, 'multiple' => true, 'required' => false, 'constraints' => [
                new All([
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image',
                        ])
                    ]
                ])
            ]])
            ->add('Submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
