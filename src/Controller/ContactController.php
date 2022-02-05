<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $req , ManagerRegistry $doctrine, MailerInterface $mailer): Response
    {
        $em = $doctrine->getManager();
        $contact = new Contact();
        $form= $this->createForm(ContactType::class, $contact, [
            'action' => $this->generateUrl('contact'),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
           $em->persist($contact);
           $em->flush();
           $this->addFlash('success', 'Your message has been sent. Thank you!');
           $email = (new Email())
           ->from(new Address('contact.nftmarket@gmail.com', 'NFT-MARKET'))
           ->to($contact->getEmail())
           ->subject('NFT-MARKET CONTACT')
           ->html('<h1>Bienvenu '.$contact->getName().' !</h1><br/><p>nous avons recu votre contact sur : '.$contact->getSubject().' .</p>');

           

  
   $mailer->send($email);

        }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }
}