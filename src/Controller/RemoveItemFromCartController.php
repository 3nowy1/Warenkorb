<?php

namespace App\Controller;

use App\DTO\CartItemDTO;
use App\Services\ShoppingCartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RemoveItemFromCartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartService $shoppingCartService) {}

    #[Route('/api/carts/{cartId}/products/{productId}', name: 'api_remove_cart_item', methods: ['DELETE'])]
    public function removeCartItem(string $cartId, string $productId): JsonResponse
    {
        if(empty($productId))
        {
            return new JsonResponse('product could not be found.', 404);
        }

        $shoppingCart = $this->shoppingCartService->removeShoppingCartItem($cartId, $productId);

        return new JsonResponse(['shoppingCart' => $shoppingCart->toArray()]);
    }
}
