<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;


class CréateursController extends AbstractController
{
    #[Route('/createurs', name: 'cr_ateurs')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {
        $users =$doctrine->getRepository(User::class)->findAll();
        return $this->render('créateurs/index.html.twig', [
            'controller_name' => 'CréateursController',
            'users'=>$users
        ]);
    }
}
