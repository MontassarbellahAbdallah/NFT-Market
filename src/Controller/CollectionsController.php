<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectionsController extends AbstractController
{
    #[Route('/collections', name: 'collections')]
    public function index(): Response
    {
        return $this->render('collections/index.html.twig', [
            'controller_name' => 'CollectionsController',
        ]);
    }
}
