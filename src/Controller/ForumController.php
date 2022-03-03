<?php

namespace App\Controller;

use App\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Forum;
use App\Form\ForumType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AnswerType;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'forum')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum, [
            'action' => $this->generateUrl('forum'),
            'method' => 'POST',
        ]);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($forum);
            $em->flush();
            $this->addFlash('success', 'Your Forum has been added. Thank you!');
            return $this->redirectToRoute('forum');
        }
        $forums = $doctrine->getRepository(Forum::class)->findAll();
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'form' => $form->createView(),
            'forums' => $forums,
        ]);
    }

    #[Route('/forum/detail/{id}', name: 'froum_detail')]
    public function Answer(Request $req, ManagerRegistry $doctrine, Forum $forum): Response
    {

        $id_forum = $forum->getId();
        $em = $doctrine->getManager();
        $answer = new Answer();
        $formAns = $this->createForm(AnswerType::class, $answer, [
            'action' => $this->generateUrl('froum_detail', ['id' => $id_forum]),
            'method' => 'POST',
        ]);
        $formAns->handleRequest($req);
        if ($formAns->isSubmitted() && $formAns->isValid()) {
            $email = $this->getUser()->getEmail();
            $answer->setForum($id_forum);
            $answer->setEmail($email);
            $em->persist($answer);
            $em->flush();
            return $this->redirectToRoute('froum_detail', ['id' => $id_forum]);
        }
        $answers = $doctrine->getRepository(Answer::class)->findByForum($id_forum);
        return $this->render('forum/answer.html.twig', [
            'controller_name' => 'ForumController',
            'answers' => $answers,
            'forum' => $forum,
            'form' => $formAns->createView(),

        ]);
    }
}
