<?php

namespace App\Service;

use App\Entity\Contact;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function envoyer(Contact $contact, $subject, $page):void
    {
        if ($page == 'contact') {
            $message = '<h1>Bienvenue ' . $contact->getName() . ' !</h1><br/><p>nous avons recu votre contact sur : ' . $contact->getSubject() . ' .</p>';
        } else {
            $message = 'erreur de message';
        }
        try {
            $email = (new Email())
                ->from(new Address('contact.nftmarket@gmail.com', 'NFT-MARKET'))
                ->to($contact->getEmail())
                ->subject($subject)
                ->html($message);
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
        }

    }
}