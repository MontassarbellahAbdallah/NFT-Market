<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Collect;
use App\Entity\User;
use App\Entity\NFT;

class CollectionsController extends AbstractController
{
    #[Route('/collections', name: 'collections')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $nature = 'descri';
        $nfts = $em->getRepository(NFT::class)->findByName($nature);
        dump($nfts);die;
        
        
        $nft = $request->get('nft');
        $user = $em->find(User::class, 18);
        if($user && $nft){
            $collection = new Collect();
            if($user->getCollect()) //il a déjà une collection
            {
                //ajouter nft à cette collection du user
                $collection = $user->getCollect();
            }else // il n'a pas de collection
            {
                // créer la collection avant de lui affecter l'nft
                 $collection->setUser($user);
                 $em->persist($collection);
                 $em->flush();
            }
            $collection->addNft($nft);
            $nft->setCollect($collection);
            $em->flush();
        }

        return $this->render('collections/index.html.twig', [
            'controller_name' => 'CollectionsController',
        ]);
    }
}
