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
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartService $shoppingCartService)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/edit/cart/item', name: 'api_edit_cart', methods: ['PATCH'])]
    public function editCartItem(Request $request): JsonResponse
    {
        $cartItem = new CartItemDTO(...$request->toArray());
        if(empty($cartItem->getProductId()) || empty($cartItem->getQuantity()))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $shoppingCart = $this->shoppingCartService->createNewShoppingCart($cartItem);

        return new JsonResponse(['cartId' => $shoppingCart->getCartId()]);
    }
}
