<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $activecategories = $categorieRepository->findTopCategories(6);
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'activecategories' => $activecategories,
        ]);
    }

    // ✅ 1. Все блюда (обычная страница, без React)
    #[Route('/plats', name: 'app_plat')]
    public function catalogue(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $plats,
        ]);
    }

    #[Route('/plats/{id}', name: 'app_platcat', methods: ['GET'])]
    public function platsByCategoryPage($id): Response
    {
        return $this->render('catalogue/platscat.html.twig', [
            'categoryId' => $id
        ]);
    }
    
    // API для React
    #[Route('/api/plats/{id}', name: 'api_platcat', methods: ['GET'])]
    public function getPlatsByCategory($id, PlatRepository $platRepository): JsonResponse
    {
        $plats = $platRepository->findBy(['categorie' => $id]);
    
        $data = array_map(function($plat) {
            return [
                'id' => $plat->getId(),
                'title' => $plat->getTitle(),
                'description' => $plat->getDescription(),
                'prix' => $plat->getPrix(),
                'image' => $plat->getImage(),
                'categorie' => [
                    'id' => $plat->getCategorie()->getId(),
                    'libelle' => $plat->getCategorie()->getLibelle(),
                ]
            ];
        }, $plats);
    
        return $this->json($data);
    }
    

    #[Route('/categories', name: 'app_categories')]
    public function categories(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findActiveCategories();

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
