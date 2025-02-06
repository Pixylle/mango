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
public function index(SessionInterface $session, \Doctrine\ORM\EntityManagerInterface $entityManager): Response
{
    $cart = $session->get('cart', []);
    $repository = $entityManager->getRepository(\App\Entity\Plat::class);
    $cartWithDetails = [];

    foreach ($cart as $id => $item) {
        $plat = $repository->find($id);
        if ($plat) {
            $cartWithDetails[$id] = [
                'id' => $id,
                'name' => $plat->getTitle(),
                'price' => $plat->getPrix(),
                'quantity' => $item['quantity'],
                'image' => $plat->getImage(), // Делаем доступным путь к изображению
            ];
        }
    }

    return $this->render('panier/index.html.twig', [
        'cart' => $cartWithDetails,
    ]);
}

    
    

    #[Route('/panier/add/ajax/{id}', name: 'add_to_cart_ajax', methods: ['POST'])]
    public function addToCartAjax(int $id, SessionInterface $session): JsonResponse
    {
        // Получаем текущую корзину
        $cart = $session->get('cart', []);

        // Если товар отсутствует, добавляем его, иначе увеличиваем количество
        if (!isset($cart[$id])) {
            $cart[$id] = ['id' => $id, 'name' => "Nom du plat $id", 'quantity' => 1, 'price' => 10.0]; // Пример цены и имени
        } else {
            $cart[$id]['quantity']++;
        }

        // Обновляем корзину в сессии
        $session->set('cart', $cart);

        // Рассчитываем общее количество товаров
        $totalItems = array_sum(array_column($cart, 'quantity'));

        // Возвращаем JSON-ответ
        return new JsonResponse(['success' => true, 'totalItems' => $totalItems]);
    }

    #[Route('/panier/remove/{id}', name: 'cart_remove', methods: ['POST'])]
   
public function removeItem(int $id, SessionInterface $session): JsonResponse
{
    $cart = $session->get('cart', []);
    
    if (isset($cart[$id])) {
        unset($cart[$id]);
        $session->set('cart', $cart);
    }

    return $this->json(['success' => true]);
}

#[Route('/panier/clear', name: 'cart_clear', methods: ['POST'])]

public function clearCart(SessionInterface $session): JsonResponse
{
    $session->set('cart', []);
    return $this->json(['success' => true]);
}

}
