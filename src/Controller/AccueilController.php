<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        // Получаем активные категории
        $activecategories = $categorieRepository->findTopCategories(6);

        // Отправляем категории на главную страницу
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'activecategories' => $activecategories,
        ]);
    }
}

