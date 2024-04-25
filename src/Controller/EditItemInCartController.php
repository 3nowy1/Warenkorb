<?php

namespace App\Controller;

use App\DTO\CartItemDTO;
use App\Services\ShoppingCartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditItemInCartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartService $shoppingCartService) {}

    #[Route('/api/carts/{cartId}/products/{productId}', name: 'api_edit_cart_item', methods: ['PATCH'])]
    public function editCartItem(string $cartId, string $productId, Request $request): JsonResponse
    {
        $quantity = $request->toArray()['quantity'];

        if(empty($productId) || empty($quantity))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $cartItem = new CartItemDTO($productId, $quantity);
        $shoppingCart = $this->shoppingCartService->editShoppingCartItem($cartId, $cartItem);

        return new JsonResponse(['shoppingCart' => $shoppingCart->toArray()]);
    }
}
