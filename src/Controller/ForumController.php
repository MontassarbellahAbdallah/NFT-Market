<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Forum;
use App\Form\ForumType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'forum')]
    public function index(Request $req , ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $forum = new Forum();
        $form= $this->createForm(ForumType::class, $forum, [
            'action' => $this->generateUrl('forum'),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
           $em->persist($forum);
           $em->flush();
           $this->addFlash('success', 'Your Forum has been added. Thank you!');
        }
        $forums=$doctrine->getRepository(Forum::class)->findAll();
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'form' => $form->createView(),
            'forums' => $forums,
        ]);
    }
}
