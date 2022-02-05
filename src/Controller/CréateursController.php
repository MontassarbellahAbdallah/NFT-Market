<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CréateursController extends AbstractController
{
    #[Route('/createurs', name: 'cr_ateurs')]
    public function index(): Response
    {
        return $this->render('créateurs/index.html.twig', [
            'controller_name' => 'CréateursController',
        ]);
    }
}
