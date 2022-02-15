<?php

namespace App\Form;

use App\Entity\NFT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class NFTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('titre', TextType::class, ['attr' => ['placeholder' => 'Titre *']], ['required' => true])
            ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Description *']], ['required' => true])
            ->add('nombre', NumberType::class, ['attr' => ['placeholder' => 'Le nombre  *']], ['required' => true])
            ->add('prix', NumberType::class, ['attr' => ['placeholder' => 'Prix *']], ['required' => true])
            ->add('photo', FileType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NFT::class,
        ]);
    }
}
