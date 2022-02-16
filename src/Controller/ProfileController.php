<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\NFT;

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
}
