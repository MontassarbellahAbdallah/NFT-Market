<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarketplaceController extends AbstractController
{
    #[Route('/marketplace', name: 'marketplace')]
    public function index(): Response
    {
        return $this->render('marketplace/index.html.twig', [
            'controller_name' => 'MarketplaceController',
        ]);
    }
}
