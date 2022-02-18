<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\NFT;
use App\Entity\User;
use App\Form\ModifierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class ProfileController extends AbstractController
{
    // public function __toString()
    // {
    //     return (string) ;
    // }
    #[Route('/profile', name: 'profile')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $email = $this->getUser()->getEmail();
        $nft =$doctrine->getRepository(NFT::class)->findByEmail($email);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'nft'=>$nft,
        ]);
    }

    #[Route('/profile/settings', name: 'settings')]
    public function settings(Request $req, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager): Response
    {
        $em = $doctrine->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ModifierType::class, $user, [
            'action' => $this->generateUrl('settings'),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $username = $form->get('username')->getData();
            $pasword = $form->get('password')->getData();
            $bio = $form->get('bio')->getData();
            $facebook = $form->get('facebook')->getData();
            $twitter = $form->get('twitter')->getData();
            $discord = $form->get('discord')->getData();

            if($pasword != $user->getPassword()){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $pasword
                    )
                );
                

            }
            $user->setBio($bio);
            $user->setUsername($username);
            $user->setFacebook($facebook);
            $user->setTwitter($twitter);
            $user->setDiscord($discord);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profile');
        
        }


        return $this->render('profile/settings.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=>$user,
            'form' => $form->createView(),
            
        ]);
    }

  
}
