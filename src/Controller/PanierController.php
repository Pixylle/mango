<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    #[Route('/panier/add/ajax/{id}', name: 'add_to_cart_ajax', methods: ['POST'])]
    public function addToCartAjax(int $id, SessionInterface $session): JsonResponse
    {
        $cart = $session->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = ['id' => $id, 'quantity' => 1];
        } else {
            $cart[$id]['quantity']++;
        }

        $session->set('cart', $cart);

        // Возвращаем JSON-ответ с текущим количеством товаров в корзине
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return new JsonResponse(['success' => true, 'totalItems' => $totalItems]);
    }
}
