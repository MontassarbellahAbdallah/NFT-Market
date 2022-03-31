<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //      return $this->redirectToRoute('acceuil');
        //  }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/login/wallet", name="login_wallet")
     */    
    public function registerWallet(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        /*$user = $request->get('data');
        if($user){
            $id = key_exists('id', $user)?$user['id']:null;
        }*/
        
        dump($request->get('data'));
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
     
        return $this->render('security/loginWallet.html.twig', ['last_username' => $lastUsername, 'error' => $error,
        'user'=>$lastUsername

    ]);
    }
    /**
     * @Route("/test/wallet", name="test_wallet")
     */
    public function testwallet(Request $request,EntityManagerInterface $em): Response
    {
        $user = $request->get('data');
        if($user){
            $id = key_exists('id', $user)?$user['id']:null;
            $user = $em->getRepository(User::class)->findOneBy(['id'=>$id]);
            if(!$user){
                $user = new User();

                dump($user);die;

            }
            
        }
    }
}
