<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class ModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class, ['attr' => ['placeholder' => 'Votre nom*']] , ['required'=>true])
            ->add('photo', FileType::class, [
                'required' =>false,
                'label' => 'profile photo (img file)',
                'mapped'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '3M',
                        'maxSizeMessage' => 'these files are too large, max size is 3M',
                        'mimeTypes' => array("image/*"),
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ]),
                ],
            ])

            ->add('couverture', FileType::class, [
                'required' =>false,
                'label' => 'profile photo (img file)',
                'mapped'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '3M',
                        'maxSizeMessage' => 'these files are too large, max size is 3M',
                        'mimeTypes' => array("image/*"),
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ]),
                ],
            ])

            ->add('password',TextType::class, ['attr' => ['placeholder' => '*********']] )
            ->add('facebook',TextType::class, ['attr' => ['placeholder' => 'votre nom de Facebook ']] )
            ->add('twitter',TextType::class, ['attr' => ['placeholder' => 'votre nom de Twitter ']] )
            ->add('discord' ,TextType::class, ['attr' => ['placeholder' => 'votre nom de Discord ']] )
            ->add('bio',TextareaType::class, ['attr' => ['placeholder' => 'Bio ']] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
