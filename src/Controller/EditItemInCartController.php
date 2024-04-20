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

class EditItemInCartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartService $shoppingCartService)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/edit/cart/item/{cartId}', name: 'api_edit_cart_item', methods: ['PATCH'])]
    public function addItemToCart(Request $request, string $cartId): JsonResponse
    {
        $this->createCart();
        $cartItem = new CartItemDTO(...$request->toArray());
        if(empty($cartItem->getProductId()) || empty($cartItem->getQuantity()))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $cardDTO = new CartDTO($cartId);
        $shoppingCart = $this->shoppingCartService->addItemToShoppingCart($cardDTO, $cartItem);

        return new JsonResponse(['cartId' => $shoppingCart->getCartId()]);
    }
}
