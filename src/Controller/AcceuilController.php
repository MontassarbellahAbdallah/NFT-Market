<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\NFT;


class AcceuilController extends AbstractController
{
    #[Route('/', name: 'acceuil')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {

        $users =$doctrine->getRepository(User::class)->findAll();
        $nfts =$doctrine->getRepository(NFT::class)->findAll();
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'users'=>$users,
            'nfts'=>$nfts,
        ]);
    }
    // Item-details
    #[Route('/item-details/{id}', name: 'item-details')]
    public function itemDetails(Request $req,NFT $nft, ManagerRegistry $doctrine): Response
    {
       $email = $nft->getEmail();
       $users =$doctrine->getRepository(User::class)->findByEmail($email); 
       $prix_eth = $nft->getPrix();
       $prix = $prix_eth * 2446 ;
       
       
    
        return $this->render('acceuil/item-details.html.twig', [
            'controller_name' => 'AcceuilController',
            'nft'=>$nft,
            'email'=>$email,
            'user'=>$users,
            'prix'=>$prix,
            
        ]);
    }
}
