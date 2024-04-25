<?php

namespace App\Controller;

use App\DTO\CartDTO;
use App\DTO\CartItemDTO;
use App\Services\ShoppingCartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddItemToCartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartService $shoppingCartService) {}

    #[Route('/create/cart', name: 'api_new_cart', methods: ['POST'])]
    public function createNewCart(Request $request): JsonResponse
    {
        $cartItem = new CartItemDTO(...$request->toArray());
        if(empty($cartItem->getProductId()) || empty($cartItem->getQuantity()))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $shoppingCart = $this->shoppingCartService->createNewShoppingCart($cartItem);

        return new JsonResponse(['shoppingCart' => $shoppingCart->toArray()]);
    }

    #[Route('/add/cart/item/{cartId}', name: 'api_add_products', methods: ['POST'])]
    public function addItemToCart(Request $request, string $cartId): JsonResponse
    {
        $cartItem = new CartItemDTO(...$request->toArray());
        if(empty($cartItem->getProductId()) || empty($cartItem->getQuantity()))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $cardDTO = new CartDTO($cartId);
        $shoppingCart = $this->shoppingCartService->addItemToShoppingCart($cardDTO, $cartItem);

        return new JsonResponse(['shoppingCart' => $shoppingCart->toArray()]);
    }
}
