<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PlatsController extends AbstractController
{
    #[Route('/plats', name: 'app_plats')]
    public function index(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        return $this->render('plats/index.html.twig', [
            'plats' => $plats,
        ]);
    }
}



