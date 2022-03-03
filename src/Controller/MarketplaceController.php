<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\NFT;
use App\Entity\Transaction;
use App\Form\TransactionType;

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

    #[Route('/acheter/{id}', name: 'acheter')]
    public function Acheter(Request $req,ManagerRegistry $doctrine,NFT $nft): Response
    {
        
        $id_nft = $nft->getId();
        $em = $doctrine->getManager();
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction, [
            'action' => $this->generateUrl('acheter' , ['id' => $id_nft]),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setFf($nft->getEmail());
            $transaction->setIdNft($id_nft);
            $transaction->setTt($this->getUser()->getEmail());
            $qte = $form->get('qte')->getData();
            $prix = ($nft->getPrix()*$qte)*5/100;
            $transaction->setPrix($prix);
            if ($this->getUser()->getPoints() >= $prix) {
                $em->persist($transaction);
                $nft->setEmail($this->getUser()->getEmail());
                $em->flush();
                $this->addFlash('success', 'Your Achat has been added. Thank you!');
            }
            else{
                $this->addFlash('success', 'Erreur solde insuffisant!');
            }
           
         
        }
    
       $nfts =$doctrine->getRepository(NFT::class)->findById($id_nft); 
       $frais = ($nft->getPrix())*5/100; 
        return $this->render('marketplace/acheter.html.twig', [
            'controller_name' => 'MarketplaceController',
            'nft'=>$nfts,
            'frais'=>$frais,
            'form' => $form->createView(),
        ]);
    }
}
