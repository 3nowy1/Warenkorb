<?php

namespace App\Controller;

use App\DTO\CartDTO;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShowCartController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager, private ShoppingCartRepository $shoppingCartRepository) {}

    #[Route('/api/carts/{cartId}', name: 'api_show_cart', methods: ['GET'])]
    public function showCart(string $cartId): JsonResponse
    {
        if (empty($cartId)) {
            return new JsonResponse('Shoppingcart could now be found.', 404);
        }

        $cartEntity = $this->shoppingCartRepository->findOneBy(['id' => $cartId]);

        $cartDTO = new CartDTO($cartEntity->getId());
        $cartDTO->setItems($cartEntity->getItems());

        return new JsonResponse(['shoppingCart' => $cartDTO->toArray()]);
    }
}
