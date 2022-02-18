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
}
