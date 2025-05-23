<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, ['attr' => ['placeholder' => 'Entrer votre email *']] , ['required'=>true])
            ->add('username',TextType::class, ['attr' => ['placeholder' => 'Entrer votre nom & prenom *']] , ['required'=>true])
            ->add('password',PasswordType::class, ['attr' => ['placeholder' => 'Entrer votre mot de passe *']] , ['required'=>true])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
