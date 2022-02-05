<?php

namespace App\Form;

use App\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ForumType extends AbstractType
{
    const type=["Probleme  d'inscription","Probleme d'authentification","Probleme d'UPLOAD","Autres Probleme"];
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, ['attr' => ['placeholder' => 'Email *']] , ['required'=>true])
            ->add('titre',TextType::class, ['attr' => ['placeholder' => 'Titre*']] , ['required'=>true])
            ->add('message',TextareaType::class, ['attr' => ['placeholder' => 'Votre Message...']] , ['required'=>true])
            ->add('categorie' , ChoiceType::class,['choices'=>array_combine(self::type, self::type)])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}