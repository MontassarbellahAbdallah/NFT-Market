<?php

namespace App\Form;

use App\Entity\NFT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;



class NFTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('titre', TextType::class, ['attr' => ['placeholder' => 'Titre *']], ['required' => true])
            ->add('description', TextType::class, ['attr' => ['placeholder' => 'Description *']], ['required' => true])
            ->add('nombre', NumberType::class, ['attr' => ['placeholder' => 'Le nombre  *']], ['required' => true])
            ->add('prix', NumberType::class, ['attr' => ['placeholder' => 'Prix *']], ['required' => true])
            ->add('photo', FileType::class, [
                //'label' => 'Brochure (PDF file)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                //'required' => true,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '300M',
                        'mimeTypes' => [
                            'image/*',
                            'videos/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid NFT',
                    ])
                ],
            ])
           
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NFT::class,
        ]);
    }
}
