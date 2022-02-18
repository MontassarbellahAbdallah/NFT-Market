<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\NFT;

class MarketplaceController extends AbstractController
{
    #[Route('/marketplace', name: 'marketplace')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {

        $nfts =$doctrine->getRepository(NFT::class)->findAll();
        return $this->render('marketplace/index.html.twig', [
            'controller_name' => 'MarketplaceController',
            'nfts'=>$nfts,
        ]);
    }
}
