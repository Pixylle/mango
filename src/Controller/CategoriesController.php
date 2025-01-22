<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository; // Импортируем репозиторий

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        // Получаем все активные категории через метод репозитория
        $categories = $categorieRepository->findActiveCategories();

        // Отправляем категории в шаблон
        return $this->render('categories/index.html.twig', [
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
