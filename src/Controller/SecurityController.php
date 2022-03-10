<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request,AuthenticationUtils $authenticationUtils ,ManagerRegistry $doctrine ): Response
    {
        // if ($this->getUser()) {
        //      return $this->redirectToRoute('acceuil');
        //  }
        
            // $user_adresse = $request->get('data');
            // dump($user_adresse);die;
        

        // $user_adresse = $request->get('data');
        
        // if ($user_adresse) {
        //     $user =  $doctrine->getRepository(User::class)->findByAdressewallet($user_adresse);
        // $email = (String) $user[0]->getEmail();
       
        // $password = (String) $user[0]->getPassword();
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
        ['last_username' => $lastUsername,'password'=>'$password' , 'user_adresse'=>'$user_adresse', 'error' => $error]
    );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    
}
