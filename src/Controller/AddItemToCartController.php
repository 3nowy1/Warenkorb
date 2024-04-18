<?php

namespace App\Controller;

use App\DTO\CartDTO;
use App\DTO\CartItemDTO;
use App\Entity\ShoppingCart;
use App\Services\ShoppingCartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddItemToCartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartService $shoppingCartService)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/carts', name: 'api_carts', methods: ['POST'])]
    public function createNewCart(Request $request): JsonResponse
    {
        $cartItem = new CartItemDTO(...$request->toArray());
        if(empty($cartItem->getProductId()) || empty($cartItem->getQuantity()))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $shoppingCart = $this->shoppingCartService->createNewShoppingCart($cartItem);

        return new JsonResponse(['cartId' => $shoppingCart->getCartId()]);
    }

    #[Route('/api/carts/{cartId}/products', name: 'api_carts_products', methods: ['POST'])]
    public function addItemToCart(#[MapRequestPayload] CartDTO $cartItem): JsonResponse
    {
        if(empty($productId) || empty($quantity))
        {
            return new JsonResponse('please pick a product and quantity first', 400);
        }

        $shoppingCart = new ShoppingCart();
        $shoppingCart->setItems(['product_id' => $productId, 'quantity' => $quantity]);

        $this->entityManager->persist($shoppingCart);

        $this->entityManager->flush();

        return new JsonResponse('Saved new product with id '.$shoppingCart->getId(), 200);
    }
}
