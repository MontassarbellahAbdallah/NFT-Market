<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\NFT;
use App\Form\NFTType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\String\Slugger\SluggerInterface;

class AjouteController extends AbstractController
{
    public function __toString()
{
    return (string) $this->getEmail();
}

    #[Route('/ajoute', name: 'ajoute')]
    public function index(Request $req, ManagerRegistry $doctrine, MailerInterface $mailer, SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        $nft = new NFT();
        $form = $this->createForm(NFTType::class, $nft, [
            'action' => $this->generateUrl('ajoute'),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        $user = $this->getUser()->getEmail();
        $nft->setEmail($user);
        $dir =  $this->getParameter('nfts');
        if ($form->isSubmitted() && $form->isValid()) {  
            $image = $form->get('photo')->getData();
            if ($image) {
                // $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // $safeFilename = $slugger->slug($originalFilename);
                $newFilename =  uniqid() . '.' . $image->guessExtension();
                // ajouetr la nouvelle image : Move the file to the directory where images are stored
               // ajouetr la nouvelle image : Move the file to the directory where images are stored
               try {
                $image->move(
                    $dir,
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $nft->setPhoto($newFilename);

            } 
            $em->persist($nft);
            $em->flush();
            $this->addFlash('success', 'Your ajout has been sent. Thank you!');
            $email = (new Email())
           ->from(new Address('contact.nftmarket@gmail.com', 'NFT-MARKET'))
           ->to($user)
           ->subject('NFT-MARKET Ajout')
           ->html('<h1>Ajoute avec success</h1>');
            $mailer->send($email);
            //$emailSender->envoyer($contact,'NFT-MARKET CONTACT','contact');
            return $this->redirectToRoute('ajoute');
        }
        return $this->render('ajoute/index.html.twig', [
            'controller_name' => 'AjouteController',
            'form' => $form->createView(),
            
        ]);
    }
}
