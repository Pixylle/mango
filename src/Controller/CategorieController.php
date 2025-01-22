<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{id}/plats', name: 'api_categorie_plats')]
    public function getPlatsByCategorie(int $id, PlatRepository $platRepository)
    {
        // Получаем блюда по ID категории
        $plats = $platRepository->findByCategorieId($id);

        // Передаем данные в шаблон Twig
        return $this->render('categorie/plats.html.twig', [
            'plats' => $plats,
        ]);
    }
}
