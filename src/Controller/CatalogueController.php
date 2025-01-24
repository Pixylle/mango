<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        // Получаем активные категории
        $activecategories = $categorieRepository->findTopCategories(6);
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'activecategories' => $activecategories,
        ]);
    }


    #[Route('/plats', name: 'app_plat')]
    public function catalogue(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $plats,
        ]);
    }

    #[Route('/plats/{id}', name: 'app_platcat')]
    public function platcat(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        return $this->render('catalogue/platscat.html.twig', [
            'plats' => $plats,
        ]);
    }


    #[Route('/categories', name: 'app_categories')]
    public function categories(CategorieRepository $categorieRepository): Response
    {
        // Получаем все активные категории через метод репозитория
        $categories = $categorieRepository->findActiveCategories();

        // Отправляем категории в шаблон
        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categories,
        ]);
    }

    #[Route('/categories/activate', name: 'activate_categories')]
public function activateCategories(CategorieRepository $categorieRepository): Response
{
    $categorieRepository->activateAllCategories();

    return new Response('Все категории успешно активированы!');
}
}
